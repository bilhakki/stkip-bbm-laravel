import fetch from "../../../../helpers/fetch";
import { defaultBody } from "./index";
import funCommon from "../modules/common";
import selectStudents from "../modules/selectStudents";
import selectSeasons from "../modules/selectSeasons";

window.editModal = editModal;
function editModal(element) {
    return {
        element,
        errors: null,
        body: { ...defaultBody },
        editModalInit() {
            this.initSelectStudents();
            this.initSelectSeasons();
        },
        ...funCommon({ method: "update" }),
        ...selectStudents({ method: "edit" }),
        ...selectSeasons({ method: "edit" }),
        async editModalChangeHandler(show) {
            if (show) {
                this.loading = true;
                await this.fetchById();
                await Promise.all([
                    this.fetchCurrentStudent(),
                    this.fetchCurrentSeason(),
                ]);
            } else {
                this.body = { ...defaultBody };
            }
            this.loading = false;
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
