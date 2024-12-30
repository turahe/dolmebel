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

class ProductDto {
    id: string;
    name: string;
    price: string;
    constructor(id: string, name: string, price: string) {
        this.id = id;
        this.name = name;
        this.price = price;
    }
}

class PriceDto {
    id: string;
    currency: string;
    sale: number;
    cogs: number;
    constructor(id: string, currency: string, sale: number, cogs: number) {
        this.id = id;
        this.currency = currency;
        this.sale = sale;
        this.cogs = cogs;
    }
}

import { Product } from '@/interface';
export async function fetchProducts(url: string): Promise<Product[]> {
    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        return data.data as Product[]; // Type assertion for clarity
    } catch (error) {
        console.error('Error fetching products:', error);
        throw error; // Re-throw for potential handling in the calling component
    }
}
