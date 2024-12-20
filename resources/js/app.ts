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

// import './bootstrap';
import './splide';

import Alpine from 'alpinejs';
// @ts-ignore
import mask from '@alpinejs/mask';
// @ts-ignore
import persist from '@alpinejs/persist';
// @ts-ignore
import ajax from '@imacrayon/alpine-ajax';
import intersect from '@alpinejs/intersect';
import { Category, Product } from '@/interface';

import contactForm from '@/components/contact-form';
import { fetchCategories } from '@/components/categories';
import { fetchProducts } from '@/components/products';

Alpine.plugin(persist);
Alpine.plugin(mask);
Alpine.plugin(ajax);
Alpine.plugin(intersect);

// window.Alpine = Alpine;

interface TheCategoryState {
    loading: boolean;
    categories: Category[];
}

interface TheProductState {
    loading: boolean;
    products: Product[];
}
Alpine.data(
    'theCategories',
    (url: string) =>
        ({
            loading: false,
            categories: [],
            async fetchCategories() {
                try {
                    this.loading = true;
                    this.categories = await fetchCategories(url);
                } catch (error) {
                    console.error('Error fetching categories:', error);
                } finally {
                    this.loading = false;
                }
            },
        }) as TheCategoryState,
);

Alpine.data(
    'theProducts',
    (url: string) =>
        ({
            loading: false,
            products: [],
            async fetchProducts() {
                try {
                    this.loading = true;
                    this.products = await fetchProducts(url);
                } catch (error) {
                    console.error('Error fetching products:', error);
                } finally {
                    this.loading = false;
                }
            },
        }) as TheProductState,
);

Alpine.store('contactForm', contactForm);

Alpine.start();
