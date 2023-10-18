import { defaultBody } from "./index";
import funCommon from "../modules/common";
import selectStudents from "../modules/selectStudents";
import selectSeasons from "../modules/selectSeasons";

window.createModal = createModal;
function createModal(element) {
    return {
        element,
        errors: null,
        body: { ...defaultBody },
        createModalInit() {
            this.initSelectStudents();
            this.initSelectSeasons();
        },
        ...funCommon({ method: "store" }),
        ...selectStudents({ method: "create" }),
        ...selectSeasons({ method: "create" }),
     
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
