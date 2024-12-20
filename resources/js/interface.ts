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

interface Category {
    id: string;
    name: string;
    slug: string;
    code: string | null;
    description: string | null;
    image: string;
    icon: string;
}

interface Brand {
    id: string;
    name: string;
    logo: string;
}

interface Color {
    id: string;
    name: string;
    value: string;
}

interface Material {
    id: string;
    name: string;
}

interface Dimension {
    id: string;
    height: number;
    width: number;
    length: number;
    weight: number;
}

interface Image {
    id: string;
    url: string;
    width: number;
    height: number;
}
interface Size {
    id: string;
    name: string;
    value: string;
}
interface Product {
    id: string;
    name: string;
    slug: string;
    code: string | null;
    description: string | null;
    image: string;
    images: Image[];
    content: string;
    colors: Color[];
    sizes: Size[];
    category: Category;
    brand: Brand | null;
    materials: Material[];
    dimension: Dimension;
}

interface Country {
    name: string;
    code: string;
}

export type { Category, Product, Country };
