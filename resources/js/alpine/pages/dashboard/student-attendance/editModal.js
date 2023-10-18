import fetch from "../../../../helpers/fetch";
import { defaultBody } from "./index";
import selectStudents from "../modules/selectStudents";
import selectClassroomSessions from "../modules/selectClassroomSessions";
import funCommon from "../modules/common";

window.editModal = editModal;
function editModal(element) {
    return {
        element,
        errors: null,
        body: { ...defaultBody },
        editModalInit() {
            this.initSelectStudents();
            this.initSelectClassroomSessions();
        },
        ...funCommon({ method: "update" }),
        ...selectStudents({ method: "edit" }),
        ...selectClassroomSessions({ method: "edit" }),
        async editModalChangeHandler(show) {
            if (show) {
                this.loading = true;
                await this.fetchById();
                await Promise.all([
                    this.fetchCurrentStudent(),
                    this.fetchCurrentClassroomSession(),
                ]);
                this.loading = false;
            } else {
                this.loading = false;
                this.body = { ...defaultBody };
            }
        },
        updateSuccess(data) {
            this.element.querySelector(`button[aria-label="Close"]`).click();
            this.refreshTable();
        },
        async fetchById() {
            const data = await fetch(this.urlEdit);
            this.body = data;
            return data;
        },
    };
}
