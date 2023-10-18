import "./createModal";
import "./editModal";

export const defaultBody = {
    status: "",
    student_id: "",
    classroom_session_id: "1",
};

window.pageDashboard = pageDashboard;
function pageDashboard(element) {
    return {
        element,
        // Edit function
        data_id: null,
        urlEdit: null,
        urlUpdate: null,
        // Edit function END
        loading: false,
        initPageDashboard() {},
        refreshTable() {
            const button = document.querySelector(
                `button[aria-label="Refresh Table"]`,
            );
            if (button) button.click();
        },
    };
}
