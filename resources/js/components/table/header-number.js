const thElements = document.querySelectorAll(".table-wrapper table thead th");
if (thElements.length > 0) {
    DOMtableNumber();
    function DOMtableNumber() {
        const thElements = document.querySelectorAll(
            ".table-wrapper table thead th",
        );
        let indexOfNumber;
        thElements.forEach((th, index) => {
            const text = th.textContent.trim();
            if (["no", "nomor", "number"].includes(text.toLocaleLowerCase())) {
                indexOfNumber = index;
            }
        });
        thElements[indexOfNumber].classList.add("header-number");

        const trElements = document.querySelectorAll(
            ".table-wrapper table tbody tr",
        );
        trElements.forEach((trElement, index) => {
            const tdElements = trElement.querySelectorAll("td");
            if (tdElements[indexOfNumber]) {
                tdElements[indexOfNumber].classList.add("header-number");
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        captureXHRRequests();
    });

    function captureXHRRequests() {
        var realXHROpen = window.XMLHttpRequest.prototype.open;
        window.XMLHttpRequest.prototype.open = function () {
            this.addEventListener("load", function () {
                const response = JSON.parse(this.response);
                if (
                    response.request.path_info.startsWith("/livewire/message/")
                ) {
                    DOMtableNumber();
                }
            });
            realXHROpen.apply(this, arguments);
        };
    }
}
