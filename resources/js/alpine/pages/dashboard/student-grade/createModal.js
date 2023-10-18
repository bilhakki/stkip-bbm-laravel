import funCommon from "../modules/common";
import selectStudents from "../modules/selectStudents";
import selectSeasons from "../modules/selectSeasons";
import selectCourses from "../modules/selectCourses";
import selectClassrooms from "../modules/selectClassrooms";
import { defaultBody } from "./index";

window.createModal = createModal;
function createModal(element) {
    return {
        element,
        errors: null,
        body: { ...defaultBody },
        createModalInit() {
            this.initSelectStudents();
            this.initSelectSeasons();
            this.initSelectCourses();
            this.initSelectClassrooms();
            this.selectClassrooms.staticQuery = {
                course_id: this.body?.course_id?.value || "",
            };
        },
        ...funCommon({ method: "store" }),
        ...selectStudents({ method: "create" }),
        ...selectSeasons({ method: "create" }),
        ...selectCourses({ method: "create" }),
        ...selectClassrooms({
            method: "create",
        }),
        createModalChangeHandler(show) {
            // Reset data body saat modal di buka / tutup
            this.body = { ...defaultBody };
        },
        storeSuccess(data) {
            this.element.querySelector(`button[aria-label="Close"]`).click();
            this.refreshTable();
        },
    };
}
