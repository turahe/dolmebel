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

import { Comment, Links, MetaTag } from '@/interface';

interface Comments {
    data: Comment[];
    links: Links;
    meta: MetaTag;
}
async function fetchComments(id: string): Promise<Comments> {
    try {
        const response = await fetch(`/api/product/${id}/comments`, {
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
        return data.data as Comments;
    } catch (error) {
        console.error('Error fetching comments:', error);
        throw error; // Re-throw for potential handling in the calling component
    }
}

export { fetchComments };
export type { Comments };
