import "./bootstrap";

import Splide from "@splidejs/splide";
import "@splidejs/splide/css";

import Alpine from "alpinejs";
import mask from "@alpinejs/mask";
import persist from "@alpinejs/persist";

Alpine.plugin(persist);
Alpine.plugin(mask);
window.Alpine = Alpine;
Alpine.start();

if (document.querySelector(".splide")) {
    let splide = new Splide(".splide", {
        type: "loop",
        focus: 0,
        gap: "1rem",
        perPage: 4,
        breakpoints: {
            640: {
                perPage: 2,
            },
            480: {
                perPage: 1,
            },
        },
    });

    splide.mount();
}
