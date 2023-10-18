import "./createModal";
import "./editModal";

export const defaultBody = {
    payment_at: "",
    amount: "",
    receipt_number: "",
    status: "",
    student_id: "",
    season_id: "",
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
