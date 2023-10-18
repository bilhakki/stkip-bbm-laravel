import fetch from "../../../../helpers/fetch";
import "./createStudentModal";
import "./editStudentModal";

import "./table/filter-admission_year";
import "./table/filter-current_credits";
import "./table/filter-faculty";

window.faculties = []
window.majors = []

export const defaultBody = {
    name: "",
    email: "",
    password: "",
    date_of_birth: "",
    address: "",
    phone_number: "",
    guardian_name: "",
    guardian_phone_number: "",
    gender: "",
    blood_type: "",
    faculty_id: "",
    major_id: "",
    student_id: "",
    current_credits: 0,
    admission_year: "",
    tuition_fee: 50000,
    status: "",
};

window.pagedashboardStudent = pagedashboardStudent;
function pagedashboardStudent(element) {
    return {
        element,
        loading: false,
        faculties: [],
        majors: [],
        // Edit function
        data_id: null,
        urlEdit: null,
        urlUpdate: null,
        // Edit function END
        initPagedashboardStudent() {},
        fetchFaculties(url) {
            fetch(url).then((data) => {
                this.faculties = data;
                window.faculties = data
            });
        },
        fetchMajors(url) {
            fetch(url).then((data) => {
                this.majors = data;
                window.majors = data
            });
        },
        refreshTable() {
            const button = document.querySelector(
                `button[aria-label="Refresh Table"]`,
            );
            if (button) button.click();
        },
    };
}
