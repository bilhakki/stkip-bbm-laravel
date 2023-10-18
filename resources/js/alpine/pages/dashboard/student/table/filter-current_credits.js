const min = document.querySelector(`#table-filter-min-current_credits`);
const max = document.querySelector(`#table-filter-max-current_credits`);

document.addEventListener("DOMContentLoaded", () => {
    if (min && max) {
        ["input", "change"].forEach((event) => {
            min.addEventListener(event, function () {
                if (this.value > max.value) this.value = max.value;
            });
            max.addEventListener(event, function () {
                if (this.value < min.value) this.value = min.value;
            });
        });
    }
});
