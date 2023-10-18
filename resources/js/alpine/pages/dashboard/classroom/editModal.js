import fetch from "../../../../helpers/fetch";
import { defaultBody } from "./index";
import funCommon from "../modules/common";
import selectSeasons from "../modules/selectSeasons";
import selectCourses from "../modules/selectCourses";

window.editModal = editModal;
function editModal(element) {
    return {
        element,
        errors: null,
        body: { ...defaultBody },
        editModalInit() {
            this.initSelectSeasons();
            this.initSelectCourses();
        },
        ...funCommon({ method: "update" }),
        ...selectSeasons({ method: "edit" }),
        ...selectCourses({ method: "edit" }),
        async editModalChangeHandler(show) {
            if (show) {
                this.loading = true;
                await this.fetchById();
                await Promise.all([
                    this.fetchCurrentSeason(),
                    this.fetchCurrentCourse(),
                ]);
                this.loading = false;
            } else {
                this.body = { ...defaultBody };
                this.loading = false;
            }
        },
        editSuccess(data) {
            this.element.querySelector(`button[aria-label="Close"]`).click();
            this.refreshTable();
        },

        async fetchById() {
            const res = await fetch(this.urlEdit);
            const data = {
                ...res.user,
                ...res,
            };
            this.body = data;
            return data;
        },
    };
}
