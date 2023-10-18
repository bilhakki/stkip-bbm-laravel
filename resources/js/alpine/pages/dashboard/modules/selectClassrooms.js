import fetch from "../../../../helpers/fetch";
import Choices from "choices.js";

export default ({ method }) => {
    const key = "selectClassrooms";

    return {
        selectClassrooms: {
            el: null,
            url: null,
            urlSearch: {},
            data: [],
            staticQuery: {},
        },
        async initSelectClassrooms() {
            this[key].el = new Choices(`form.${method} [name="classroom_id"]`, {
                silent: true,
                allowHTML: false,
                searchResultLimit: 10,
                renderSelectedChoices: "always",
                searchPlaceholderValue: "Cari kelas",
            });

            this[key].url =
                this[key].el.passedElement.element.getAttribute("data-url");
            this[key].urlSearch = {};
            this[key].data = [];
            this.fetchClassrooms();

            this[key].el.passedElement.element.addEventListener(
                "search",
                async (response) => {
                    const value = response.detail.value;
                    this[key].urlSearch = {
                        s_name: value,
                    };
                    this.fetchClassrooms();
                },
                false,
            );

            this[key].el.passedElement.element.addEventListener(
                "showDropdown",
                async () => {
                    this[key].el.input.element.value = this[key].urlSearch.s_name ?? "";
                },
                false,
            );
        },
        fetchClassrooms: async function () {
            return new Promise((resolve, reject) => {
                if (this[key].fetchTimeout) {
                    clearTimeout(this[key].fetchTimeout);
                    resolve([]);
                }

                this[key].fetchTimeout = setTimeout(async () => {
                    let url = this[key].url;
                    if (Object.keys(this[key].urlSearch).length > 0) {
                        url += `?${new URLSearchParams({
                            ...this[key].staticQuery,
                            ...this[key].urlSearch,
                        }).toString()}`;
                    }
                    // this[key].el.clearStore();
                    this[key].el.setChoices(
                        await new Promise((resolve, reject) => {
                            fetch(url)
                                .then((response) => {
                                    const { data } = response;
                                    const _data = data.map((item, index) => {
                                        return {
                                            label: item.name,
                                            value: item.id,
                                            selected:
                                                item.id ==
                                                this.body.classroom_id
                                                    ? true
                                                    : false,
                                        };
                                    });
                                    this[key].data = _data;
                                    resolve(_data);
                                })
                                .catch((error) => {
                                    console.log(
                                        "🚀 ~ file: selectClassrooms.js:90 ~ fetch ~ error:",
                                        error,
                                    );
                                    resolve([]);
                                });
                        }),
                        'value',
                        'label',
                        true,
                    );
                }, 500);
            });
        },
        async fetchCurrentClassroom() {
            this[key].urlSearch = {
                s_id: this.body.classroom_id,
            };
            await this.fetchClassrooms();
        },
    };
};
