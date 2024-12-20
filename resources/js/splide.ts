/*
 * DolMebel - https://www.dolmebel.com
 *
 * @version   1.0.0
 *
 * @link      Releases - https://www.wach.id/releases
 * @link      Terms Of Service - https://www.wach.id/terms
 *
 * Copyright (c) 2024.
 *
 */

import Splide from '@splidejs/splide';
import '@splidejs/splide/css';
import { AutoScroll } from '@splidejs/splide-extension-auto-scroll';

if (document.querySelector('.splide')) {
    const splide = new Splide('.splide', {
        type: 'loop',
        focus: 0,
        gap: '1rem',
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

if (document.querySelector('.splide-scroll')) {
    const splide = new Splide('.splide-scroll', {
        type: 'loop',
        drag: 'free',
        focus: 'center',
        perPage: 3,
        autoScroll: {
            speed: 1,
        },
    });

    splide.mount();
}
