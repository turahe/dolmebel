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

import { Category, Comment, Product } from '@/interface';

type ApiResponse = Comment | Product | Category;

export default class ApiService {
    public async fetchData(endpoint: string): Promise<ApiResponse> {
        try {
            const response = await fetch(endpoint, {
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
            return res.data as ApiResponse;
        } catch (error) {
            console.error(`Error fetching data from ${endpoint}:`, error);
            throw error; // Re-throw for potential handling in the calling component
        }
    }
}
