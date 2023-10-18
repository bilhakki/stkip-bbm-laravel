import fetch from "../../../../helpers/fetch";
import { defaultBody } from "./index";

window.editStudentModal = editStudentModal;
function editStudentModal(element) {
    return {
        element,
        errors: null,
        body: { ...defaultBody },
        editStudentModalInit() {},
        async editStudentModalChangeHandler(show) {
            if (show) {
                const newBody = await this.fetchStudentById();
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
        updateStudentHandler() {
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
        async fetchStudentById() {
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
