import Swal from "sweetalert2";
import fetch from "../../helpers/fetch";

window.deleteTableRow = deleteTableRow;
function deleteTableRow(event) {
    event.preventDefault();
    event.stopPropagation();

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch
                .delete(event.target.href)
                .then((data) => {
                    const button = document.querySelector(
                        `button[aria-label="Refresh Table"]`,
                    );
                    if (button) button.click();
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener(
                                "mouseenter",
                                Swal.stopTimer,
                            );
                            toast.addEventListener(
                                "mouseleave",
                                Swal.resumeTimer,
                            );
                        },
                    });

                    Toast.fire({
                        icon: "success",
                        title: "Your file has been deleted",
                    });
                })
                .catch((error) => {
                    console.log(
                        "🚀 ~ file: deleteLecturer.js:27 ~ fetch.delete ~ error:",
                        error,
                    );
                });
        }
    });
}
