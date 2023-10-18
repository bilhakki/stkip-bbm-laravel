import "./createModal";
import "./editModal";

export const defaultBody = {
    name: "",
    position: "",
    specialization: "",
    phone_number: "",
    status: "",
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
