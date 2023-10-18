import fetch from "../../../../helpers/fetch";
import "./createModal";
import "./editModal";

export const defaultBody = {
    name: "",
    capacity: 0,
    credits: 0,
    season_id: "",
    course_id: "",
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
