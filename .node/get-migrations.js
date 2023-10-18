import fs from "fs";
import path from "path";

// Function to get the migrations directory path
function getMigrationsDir() {
    return path.join(process.cwd(), "database", "migrations");
}

// Function to read migration files and return their content
function readMigrationFiles() {
    const migrationDir = getMigrationsDir();
    return fs.readdirSync(migrationDir).map((file) => {
        const filePath = path.join(migrationDir, file);
        return { file, content: fs.readFileSync(filePath, "utf-8") };
    });
}

// Function to extract schema data from migration content
function getSchemaData(content) {
    const schemaData = [];

    // Regular expressions for extracting table and column data
    const schemaPattern =
        /Schema::create\s*\(\s*['"](\w+)['"]\s*,\s*function\s*\(Blueprint\s*\$table\)\s*{([^}]*)\}\);/gs;
    const columnPattern =
        /\$table->(integer|unsignedBigInteger|bigInteger|string|text|float|double|decimal|boolean|date|dateTime|time|timestamp|enum|foreignId)\s*\(\s*['"]([^'"]+)['"](?:\s*,\s*\[([^\]]+)\])?\s*\)/g;

    const commentPattern = /\$table->comment\s*\(\s*['"]([^'"]+)['"]\s*\)/;
    const foreignPattern =
        /\$table->foreign\s*\(\s*['"]([^'"]+)['"]\s*\)\s*->\s*references\(\s*['"]([^'"]+)['"]\s*\)/g;

    let match;
    while ((match = schemaPattern.exec(content)) !== null) {
        const tableName = match[1];
        const tableData = match[2].trim();

        const columns = [];
        let columnMatch;
        while ((columnMatch = columnPattern.exec(tableData)) !== null) {
            const type = columnMatch[1];
            const name = columnMatch[2];
            const attributes = columnMatch[3] || "";

            const commentMatch = tableData.match(
                new RegExp(
                    `\\$table->${type}\\s*\\(\\s*['"]${name}['"]\\s*\\)[^]*?->comment\\s*\\(\\s*['"]([^'"]+)['"]\\s*\\)`,
                    "i"
                )
            );
            const comment = commentMatch ? commentMatch[1] : "";

            columns.push({ type, name, attributes, comment });
        }

        let foreignKeys = [];
        let foreignMatch;
        while ((foreignMatch = foreignPattern.exec(tableData)) !== null) {
            const columnName = foreignMatch[1];
            const referenceTable = foreignMatch[2];
            foreignKeys.push({ columnName, referenceTable });
        }

        const commentMatch = tableData.match(commentPattern);
        const comment = commentMatch ? commentMatch[1] : "";

        schemaData.push({ tableName, comment, foreignKeys, columns });
    }

    return schemaData;
}

// Function to get all migrations data
function getAllMigrationsData() {
    const migrations = readMigrationFiles();

    return migrations.map((migration) => ({
        file: migration.file,
        schemaData: getSchemaData(migration.content),
    }));
}

// Function to write migrations data to disk
function writeToDisk(migrations) {
    writeFile(".schema.migrations.json", JSON.stringify(migrations, null, 2));

    let textMigrations = migrations
        .map((migration) => {
            // console.log("🚀 ~ file: get-migrations.js:88 ~ .map ~ migration:", migration)
            const { schemaData } = migration
            // console.log("🚀 ~ file: get-migrations.js:88 ~ .map ~ schemaData:", schemaData)
            if (schemaData.length) {
                const { tableName, columns, comment, foreignKeys } = schemaData[0];
                const exeptTableName = [
                    "password_reset_tokens",
                    "failed_jobs",
                    "personal_access_tokens",
                ];
                const exeptType = ["comment", "foreign"];
    
                if (!exeptTableName.includes(tableName)) {
                    const columnText = columns
                        .filter((column) => !exeptType.includes(column.type))
                        .map((column) => {
                            let text = `       - ${column.name}, type: ${column.type}`;
                            if (column.attributes) {
                                text += `, attributes: ${column.attributes}`;
                            }
                            if (column.comment) {
                                text += `, comment: ${column.comment}`;
                            }
                            return text;
                        });
    
                    const foreignKeysText = foreignKeys.map(
                        (foreignKey) =>
                            `       ${foreignKey.columnName}, reference table: ${foreignKey.referenceTable}`
                    );
                    let text = `Table: ${tableName}\n`;
                    if (comment) {
                        text += `   Comment: ${comment}\n`;
                    }
                    if (columnText) {
                        text += `   Columns:\n${columnText.join("\n")}\n`;
                    }
                    if (foreignKeys.length > 0) {
                        text += `   Foreign Keys:\n${foreignKeysText.join("\n")}\n`;
                    }
    
                    return text;
                }
            }
        })
        .filter(Boolean); // Filter out undefined elements

    textMigrations = textMigrations.join("\n");
    writeFile(".schema.migrations.txt", textMigrations);
}

function writeFile(filename, file) {
    return fs.writeFileSync(path.join(process.cwd(), ".node", filename), file);
}

function main() {
    const allMigrationsData = getAllMigrationsData();
    writeToDisk(allMigrationsData);
}

main();
