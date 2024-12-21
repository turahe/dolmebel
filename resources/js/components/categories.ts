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

import { Category } from '@/interface';
export async function fetchCategories(url: string): Promise<Category[]> {
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

        const res = await response.json();
        return res.data as Category[];
    } catch (error) {
        console.error('Error fetching categories:', error);
        throw error; // Re-throw for potential handling in the calling component
    }
}
