import { setCookie } from "../../../../../helpers/cookie";

const inputSelector = `#table-filter-faculty-wrapper input[type="checkbox"]`;
const cookieKey = "filter-student-faculty";
document.querySelectorAll(inputSelector).forEach(function (el) {
    el.addEventListener("change", (e) => {
        let values = [];

        if (e.target.value === "on") {
            if (
                document.querySelector(
                    inputSelector + `#table-filter-faculty-select-all`,
                ).checked
            ) {
                document
                    .querySelectorAll(inputSelector + "[value]")
                    .forEach((el) => {
                        values.push(el.value);
                    });
            } else {
                values = [];
            }
        } else {
            document
                .querySelectorAll(inputSelector + ":checked")
                .forEach((el) => {
                    values.push(el.value);
                });
        }
        setCookie(cookieKey, values);
    });
});
