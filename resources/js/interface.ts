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

interface Price {
    id: string;
    currency: string;
    cogs: string;
    sale: string;
    discount: string;
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
    price: Price;
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

interface Comment {
    id: string;
    title: string;
    content: string;
}

interface MetaTag {
    current_page: number;
    from: number;
    last_page: number;
    links: MetaTagLinks[];
    path: string;
    per_page: number;
    to: number;
    total: number;
}

interface Links {
    first: string | null;
    last: string | null;
    prev: string | null;
    next: string | null;
}

interface MetaTagLinks {
    url: string;
    label: string;
    active: boolean;
}

interface Media {
    id: string;
    name: string;
    file_name: string;
    mime_type: string;
    size: number;
    url: string;
}
export type {
    Brand,
    Category,
    Color,
    Comment,
    Country,
    Dimension,
    Image,
    Links,
    Material,
    Media,
    MetaTag,
    MetaTagLinks,
    Price,
    Product,
    Size,
};
