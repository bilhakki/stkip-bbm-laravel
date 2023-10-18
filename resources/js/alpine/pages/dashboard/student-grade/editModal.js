import fetch from "../../../../helpers/fetch";
import { defaultBody } from "./index";
import funCommon from "../modules/common";
import selectStudents from "../modules/selectStudents";
import selectSeasons from "../modules/selectSeasons";
import selectCourses from "../modules/selectCourses";
import selectClassrooms from "../modules/selectClassrooms";

window.editModal = editModal;
function editModal(element) {
    return {
        element,
        errors: null,
        body: { ...defaultBody },
        editModalInit() {
            this.initSelectStudents();
            this.initSelectSeasons();
            this.initSelectCourses();
            this.initSelectClassrooms();
            this.selectClassrooms.staticQuery = {
                course_id: this.body?.course_id?.value || "",
            };
        },
        ...funCommon({ method: "update" }),
        ...selectStudents({ method: "edit" }),
        ...selectSeasons({ method: "edit" }),
        ...selectCourses({ method: "edit" }),
        ...selectClassrooms({
            method: "edit",
        }),
        async editModalChangeHandler(show) {
            if (show) {
                this.loading = true
                await this.fetchById();
                await Promise.all([
                    this.fetchCurrentStudent(),
                    this.fetchCurrentSeason(),
                    this.fetchCurrentCourse(),
                    this.fetchCurrentClassroom(),
                ]);
                this.loading = false
            } else {
                this.body = { ...defaultBody };
                this.loading = false
            }
        },
        updateSuccess(data) {
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
