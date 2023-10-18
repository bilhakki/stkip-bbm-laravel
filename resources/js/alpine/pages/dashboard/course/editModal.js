import fetch from "../../../../helpers/fetch";
import { defaultBody } from "./index";

window.editModal = editModal;
function editModal(element) {
    return {
        element,
        errors: null,
        body: { ...defaultBody },
        editModalInit() {},
        async editModalChangeHandler(show) {
            if (show) {
                const newBody = await this.fetchById();
                this.facultyChangeHandler(newBody.faculty_id);
                this.body = newBody;
            } else {
                this.body = { ...defaultBody };
            }
        },
        editSuccess(data) {
            this.element.querySelector(`button[aria-label="Close"]`).click();
            this.refreshTable();
        },
        updateHandler() {
            this.errors = null;
            fetch
                .put(this.urlUpdate, {
                    body: this.body,
                })
                .then((data) => {
                    this.editSuccess(data);
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
        async fetchById() {
            const res = await fetch(this.urlEdit);
            const data = {
                ...res.user,
                ...res,
                faculty_id: res.major.faculty_id,
                major_id: res.major.id,
            };
            return data;
        },
        _majors: [],
        facultyChangeHandler(value) {
            this._majors = [];
            this._majors = this.majors.filter((_ma) => {
                return _ma.faculty_id == value;
            });
            return this._majors;
        },
    };
}
