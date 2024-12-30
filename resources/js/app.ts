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
import { Brand, Category, Color, Dimension, Image, Material, Media, Price, Product, Size } from '@/interface';
import collapse from '@alpinejs/collapse';
import focus from '@alpinejs/focus';
import intersect from '@alpinejs/intersect';
import mask from '@alpinejs/mask';
import persist from '@alpinejs/persist';
import Alpine from 'alpinejs';
import './splide';

import { fetchCategories } from '@/components/categories';
import { fetchProducts } from '@/components/products';
import ProductAppApi from '@/services/Product';
import { discount, formatCurrency } from '@/utils';

Alpine.plugin(persist);
Alpine.plugin(mask);
Alpine.plugin(focus);
Alpine.plugin(collapse);
Alpine.plugin(intersect);

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
                    const data: Product[] = await fetchProducts(url);
                    this.products = data.map(
                        (
                            item: Product,
                        ): {
                            id: string;
                            name: string;
                            slug: string;
                            code: string | null;
                            description: string | null;
                            image: string;
                            images: Image[];
                            content: string;
                            price: Price;
                            colors: Color[];
                            sizes: Size[];
                            category: Category;
                            brand: Brand | null;
                            materials: Material[];
                            dimension: Dimension;
                        } => ({
                            ...item,
                            price: {
                                ...item.price,
                                cogs: formatCurrency(parseFloat(String(item.price.cogs)), item.price.currency),
                                sale: formatCurrency(parseFloat(String(item.price.sale)), item.price.currency),
                                discount: discount(
                                    parseFloat(String(item.price.cogs)),
                                    parseFloat(String(item.price.sale)),
                                ),
                            },
                        }),
                    );
                } catch (error) {
                    console.error('Error fetching products:', error);
                } finally {
                    this.loading = false;
                }
            },
        }) as TheProductState,
);

Alpine.data('productApp', () => ({
    item: [],
    selectedSize: null,
    api: new ProductAppApi(),

    async addToCart(item: { product_id: string; quantity: string; size: string | null }) {
        try {
            console.log(item);
            // if (!item.size) {
            //     alert('Please select a size before adding to wishlist');
            //     return;
            // }
            // const data = { ...item };
            await this.api.cart(item);
        } catch (error) {
            console.error('Failed to add product:', error);
        }
    },
    async deleteCart(id: string) {
        try {
            return await this.api.deleteCart(id);
        } catch (error) {
            console.error('Failed to delete product:', error);
        }
    },
    async toggleLike(id: string, isLiked: boolean) {
        try {
            return await this.api.like(id, { isLiked: !isLiked });
        } catch (error) {
            console.error('Failed to toggle like:', error);
        }
    },
}));

interface ProductDetail {
    loading: boolean;
    quantity: number;
    media: Media[];
    readonly linePrice: string;
    readonly lineCogs: string;
    readonly fetchMedia: (id: string) => Promise<void>;
}
Alpine.data(
    'productDetail',
    (price: { sale: number; cogs: number; currency: string }): ProductDetail => ({
        loading: false,
        quantity: 1,
        media: [],
        get linePrice(): string {
            if (this.quantity < 1) {
                alert('quantity cannot be less than 1');
            }
            return formatCurrency(price.sale * this.quantity, price.currency);
        },
        get lineCogs(): string {
            if (this.quantity < 1) {
                alert('quantity cannot be less than 1');
            }
            return formatCurrency(price.cogs * this.quantity, price.currency);
        },

        async fetchMedia(id: string): Promise<void> {
            this.loading = true;
            try {
                const response = await fetch(`/api/media/${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const res = await response.json();
                this.media = res.data as Media[];
            } catch (error) {
                console.error('Error fetching media:', error);
            } finally {
                this.loading = false;
            }
        },
    }),
);

Alpine.start();
