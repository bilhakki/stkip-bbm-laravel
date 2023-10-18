import fetch from "../../../../helpers/fetch";
import { defaultBody } from "./index";

window.createModal = createModal;
function createModal(element) {
    return {
        element,
        errors: null,
        body: { ...defaultBody },
        createModalInit() {},
        createModalChangeHandler(show) {
            // Reset data body saat modal di buka / tutup
            this.body = { ...defaultBody };
        },
        storeSuccess(data) {
            this.element.querySelector(`button[aria-label="Close"]`).click();
            this.refreshTable();
        },
        storeHandler() {
            this.errors = null;
            const url = this.element.getAttribute("action");
            fetch
                .post(url, {
                    body: this.body,
                })
                .then((data) => {
                    this.storeSuccess(data);
                })
                .catch((error) => {
                    const message = error.message;
                    let errors = [];
                    Object.keys(error.errors).forEach((key) => {
                        errors.push(error.errors[key]);
                    });
                    this.errors = {
                        message,
                        errors,
                    };
                });
        },
        _majors: [], 
        facultyChangeHandler(value) {
            this._majors = [];
            this._majors = this.majors.filter((_ma) => {
                return _ma.faculty_id == value;
            });
        },
    };
}
