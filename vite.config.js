import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/scss/style.scss",
                "resources/js/script.js",

                // layouts
                "resources/js/alpine/layout/app.js",

                // pages
                "resources/js/alpine/pages/dashboard/student/index.js",
                "resources/js/alpine/pages/dashboard/lecturer/index.js",
                "resources/js/alpine/pages/dashboard/faculty/index.js",
                "resources/js/alpine/pages/dashboard/major/index.js",
                "resources/js/alpine/pages/dashboard/season/index.js",
                "resources/js/alpine/pages/dashboard/room/index.js",
                "resources/js/alpine/pages/dashboard/course/index.js",
                "resources/js/alpine/pages/dashboard/classroom/index.js",
                "resources/js/alpine/pages/dashboard/tuition-payment/index.js",
                "resources/js/alpine/pages/dashboard/student-attendance/index.js",
                "resources/js/alpine/pages/dashboard/student-grade/index.js",
            ],
            refresh: [...refreshPaths, "app/Http/Livewire/**", "app/Http/Controllers/**"],
        }),
    ],
});
