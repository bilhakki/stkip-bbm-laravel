import "./deleteTableRow"

window.layoutApp = layoutApp;
function layoutApp() {
    return {
        sidebarShow: false,
        showBackdrop: false,
        layoutAppInit() {
        },
        toggleSidebar() {
            this.sidebarShow = !this.sidebarShow;
            this.showBackdrop = this.sidebarShow;
        },
        closeBackdrop() {
            this.showBackdrop = false;
            this.sidebarShow = false;
        }
    };
}
