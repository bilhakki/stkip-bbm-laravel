document.querySelectorAll('[role="alert"]').forEach((alert) => {
    const buttonClose = alert.querySelector('button[aria-label="Close"]');
    if (buttonClose) {
        buttonClose.addEventListener("click", (e) => {
            alert.remove();
        });
    }
});
