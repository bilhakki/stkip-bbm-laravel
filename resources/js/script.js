import "./dark-mode";

import Alpine from "alpinejs";
import focus from "@alpinejs/focus";
import collapse from "@alpinejs/collapse";
window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.plugin(collapse);

document.addEventListener("DOMContentLoaded", () => {
    Alpine.start();
});

import "./components/alert";
import "./components/input/currency.input";

import "./components/table/header-number";


// import 'flowbite'
