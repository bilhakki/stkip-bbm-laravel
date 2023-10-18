import { defaultBody } from "./index";
import funCommon from "../modules/common";
import selectStudents from "../modules/selectStudents";
import selectClassroomSessions from "../modules/selectClassroomSessions";

window.createModal = createModal;
function createModal(element) {
    return {
        element,
        errors: null,
        body: { ...defaultBody },
        createModalInit() {
            this.initSelectStudents();
            this.initSelectClassroomSessions();
        },
        ...funCommon({ method: "store" }),
        ...selectStudents({ method: "create" }),
        ...selectClassroomSessions({ method: "create" }),
        storeSuccess(data) {
            this.element.querySelector(`button[aria-label="Close"]`).click();
            this.refreshTable();
        },
        createModalChangeHandler(show) {
            // Reset data body saat modal di buka / tutup
            this.body = { ...defaultBody };
        },
    };
}
