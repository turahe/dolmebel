import "./bootstrap";

import Splide from "@splidejs/splide";
import "@splidejs/splide/css";

import Alpine from "alpinejs";
import mask from "@alpinejs/mask";
import persist from "@alpinejs/persist";

// Import Swiper
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// TypeScript declarations
declare global {
    interface Window {
        Alpine: typeof Alpine;
        Swiper: typeof Swiper;
    }
}

Alpine.plugin(persist);
Alpine.plugin(mask);
window.Alpine = Alpine;
Alpine.start();

// Make Swiper available globally
window.Swiper = Swiper;

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
