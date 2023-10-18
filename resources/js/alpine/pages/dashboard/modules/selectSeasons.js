import fetch from "../../../../helpers/fetch";
import Choices from "choices.js";

export default ({ method }) => {
    const key = "selectSeasons";
    return {
        selectSeasons: {
            el: null,
            url: null,
            urlSearch: {},
            data: [],
        },
        async initSelectSeasons() {
            this[key].el = new Choices(`form.${method} [name="season_id"]`, {
                silent: true,
                allowHTML: false,
                searchResultLimit: 10,
                renderSelectedChoices: "always",
                searchPlaceholderValue: "Cari semester",
            });

            this[key].url =
                this[key].el.passedElement.element.getAttribute("data-url");
            this[key].urlSearch = {};
            this[key].data = [];
            this.fetchSeasons();

            this[key].el.passedElement.element.addEventListener(
                "search",
                async (response) => {
                    const value = response.detail.value;
                    this[key].urlSearch = {
                        s_name: value,
                    };
                    this.fetchSeasons();
                },
                false,
            );

            this[key].el.passedElement.element.addEventListener(
                "showDropdown",
                async () => {
                    this[key].el.input.element.value =
                        this[key].urlSearch.s_name ?? "";
                },
                false,
            );
        },
        fetchSeasons: async function () {
            return new Promise((resolve, reject) => {
                if (this[key].fetchTimeout) {
                    clearTimeout(this[key].fetchTimeout);
                    resolve([]);
                }

                this[key].fetchTimeout = setTimeout(() => {
                    let url = this[key].url;
                    if (Object.keys(this[key].urlSearch).length > 0) {
                        url += `?${new URLSearchParams(
                            this[key].urlSearch,
                        ).toString()}`;
                    }
                    fetch(url)
                        .then((response) => {
                            const { data } = response;
                            const _data = data.map((item, index) => {
                                return {
                                    label: item.name,
                                    value: item.id,
                                    selected:
                                        item.id == this.body.season_id
                                            ? true
                                            : false,
                                };
                            });
                            this[key].data = _data;
                            this[key].el.setChoices(
                                _data,
                                "value",
                                "label",
                                true,
                            );
                            resolve(_data);
                        })
                        .catch((error) => {
                            console.log(
                                "🚀 ~ file: selectSeasons.js:90 ~ fetch ~ error:",
                                error,
                            );
                            resolve([]);
                        });
                }, 500);
            });
        },
        async fetchCurrentSeason() {
            this[key].urlSearch = {
                s_id: this.body.season_id,
            };
            await this.fetchSeasons();
        },
    };
};
