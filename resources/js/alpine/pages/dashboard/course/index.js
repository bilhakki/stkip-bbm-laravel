import fetch from "../../../../helpers/fetch";

import "./createModal";
import "./editModal";

export const defaultBody = {
    name: "",
    code: "",
    credits: "",
    major_id: "",
    faculty_id: "",
};

window.pageDashboard = pageDashboard;
function pageDashboard(element) {
    return {
        element,
        loading: false,
        faculties: [],
        majors: [],
        // Edit function
        data_id: null,
        urlEdit: null,
        urlUpdate: null,
        // Edit function END
        initPageDashboard() {},
        fetchFaculties(url) {
            fetch(url).then((data) => {
                this.faculties = data;
                window.faculties = data
            });
        },
        fetchMajors(url) {
            fetch(url).then((data) => {
                this.majors = data;
                window.majors = data
            });
        },
        refreshTable() {
            const button = document.querySelector(
                `button[aria-label="Refresh Table"]`,
            );
            if (button) button.click();
        },
    };
}
