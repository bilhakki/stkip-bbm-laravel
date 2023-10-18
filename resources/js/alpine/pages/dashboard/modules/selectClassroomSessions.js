import fetch from "../../../../helpers/fetch";
import Choices from "choices.js";

export default ({ method }) => {
    const key = "selectClassroomSessions";
    return {
        selectClassroomSessions: {
            el: null,
            url: null,
            urlSearch: {},
            data: [],
        },
        async initSelectClassroomSessions() {
            this[key].el = new Choices(
                `form.${method} [name="classroom_session_id"]`,
                {
                    silent: true,
                    allowHTML: false,
                    searchResultLimit: 10,
                    renderSelectedChoices: "always",
                    searchPlaceholderValue: "Cari sesi kelas",
                },
            );

            this[key].url =
                this[key].el.passedElement.element.getAttribute("data-url");
            this[key].urlSearch = {};
            this[key].data = [];
            this.fetchClassroomSessions();

            this[key].el.passedElement.element.addEventListener(
                "search",
                async (response) => {
                    const value = response.detail.value;
                    this[key].urlSearch = {
                        s_course: value,
                        s_classroom: value,
                        s_lecturer: value,
                    };
                    this.fetchClassroomSessions();
                },
                false,
            );

            this[key].el.passedElement.element.addEventListener(
                "showDropdown",
                async () => {
                    this[key].el.input.element.value =
                        this[key].urlSearch.s_course ?? "";
                },
                false,
            );
        },
        fetchClassroomSessions: async function () {
            return new Promise((resolve, reject) => {
                if (this[key].fetchTimeout) {
                    clearTimeout(this[key].fetchTimeout);
                    resolve([]);
                }

                this[key].fetchTimeout = setTimeout(() => {
                    let url = this[key].url;
                    if (Object.keys(this[key].urlSearch).length > 0) {
                        url += `?${new URLSearchParams({
                            ...this[key].urlSearch,
                        }).toString()}`;
                    }

                    fetch(url).then((response) => {
                        const { data } = response;
                        const _data = data.map((item) => {
                            const options = {
                                year: "numeric",
                                month: "long",
                                day: "numeric",
                                hour: "numeric",
                                minute: "numeric",
                                hour12: true,
                                timeZone: "Asia/Jakarta",
                            };

                            const date = new Intl.DateTimeFormat(
                                "id-ID",
                                options,
                            ).format(new Date(item.start_datetime));

                            const label = `${date} | ${item.classroom.course.name} ${item.classroom.name} ${item.season.name} | ${item.lecturer.user.name}`;

                            return {
                                label,
                                value: item.id,
                                selected:
                                    item.id == this.body.classroom_session_id
                                        ? true
                                        : false,
                            };
                        });

                        this[key].data = _data;
                        this[key].el.setChoices(_data, "value", "label", true);
                        resolve(_data);
                    });
                }, 500);
            });
        },
        async fetchCurrentClassroomSession() {
            this[key].urlSearch = {
                s_id: this.body.classroom_session_id,
            };
            await this.fetchClassroomSessions();
        },
    };
};
