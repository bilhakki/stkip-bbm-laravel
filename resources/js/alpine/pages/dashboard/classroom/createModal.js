import { defaultBody } from "./index";
import funCommon from "../modules/common";
import selectSeasons from "../modules/selectSeasons";
import selectCourses from "../modules/selectCourses";

window.createModal = createModal;
function createModal(element) {
    return {
        element,
        errors: null,
        body: { ...defaultBody },
        createModalInit() {
            this.initSelectSeasons();
            this.initSelectCourses();
        },
        ...funCommon({ method: "store" }),
        ...selectSeasons({ method: "create" }),
        ...selectCourses({ method: "create" }),
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
