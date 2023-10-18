import "./createModal";
import "./editModal";

import "./table/filter-faculty";

export const defaultBody = {
    grade: 0,
    student_id: "",
    course_id: "",
    classroom_id: "",
    season_id: "",
    user_id: "",
};

window.pageDashboard = pageDashboard;
function pageDashboard(element) {
    return {
        element,
        loading: false,
        // Edit function
        data_id: null,
        urlEdit: null,
        urlUpdate: null,
        // Edit function END
        initPageDashboard() {},
        refreshTable() {
            const button = document.querySelector(
                `button[aria-label="Refresh Table"]`,
            );
            if (button) button.click();
        },
    };
}
