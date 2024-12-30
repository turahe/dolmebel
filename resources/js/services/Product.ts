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

class ProductAppApi {
    async cart<T>(data: T): Promise<T> {
        try {
            const response = await fetch('/product/cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                },
                body: JSON.stringify(data),
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const res = await response.json();
            return res.data;
        } catch (error) {
            console.error('Error reading resource:', error);
            throw error;
        }
    }

    async deleteCart(id: string): Promise<Response> {
        try {
            return await fetch(`/products/${id}/cart`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                },
            });
        } catch (error) {
            console.error('Error deleting resource:', error);
            throw error;
        }
    }

    async like<T>(id: string, data: T): Promise<Response> {
        try {
            return await fetch(`/products/${id}/like`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });
        } catch (error) {
            console.error('Error updating resource:', error);
            throw error;
        }
    }
}

export default ProductAppApi;
