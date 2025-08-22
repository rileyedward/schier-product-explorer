import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface ProductCategory {
    object: string;
    url: string;
    name: string;
    key: string;
    active: boolean;
    image?: string | null;
    created: string;
    last_updated: string;
    parent? : string | null;
    types?: string[];
}

export interface Measurement {
    object: string;
    value: number;
    unit: string;
}

export interface Dimensions {
    object: string;
    length: Measurement;
    width: Measurement;
    height: Measurement;
    weight: Measurement;
}

export interface DimensionSet {
    object: string;
    standard: Dimensions;
    metric: Dimensions;
}

export interface ImageLibrary {
    object: string;
    orig: string;
    lg: string;
    md: string;
    sm: string;
}

export interface ProductImageLibrary {
    object: string;
    primary: ImageLibrary;
    dimension: ImageLibrary;
}

export interface Price {
    object: string;
    price: string;
    multiplier: number;
}

export interface ProductPrice {
    object: string;
    list: string;
    retail: Price;
    wholesale: Price;
    stocking_wholesale: Price;
}

export interface Product {
    id: number;
    name: string;
    short_name: string;
    part_number: string;
    store_id?: string;
    shipping_group?: string;
    active: boolean;
    visible_on_store: boolean;
    description?: string;
    short_description?: string;
    website_url?: string;
    types?: string[];
    images?: ProductImageLibrary;
    price?: ProductPrice;
    base_dimensions?: DimensionSet;
    shipping_dimensions?: DimensionSet;
    created?: string;
    updated?: string;
    created_at: string;
    updated_at: string;
    productTypes?: ProductType[];
}

export interface ProductType {
    id: number;
    object: string;
    url: string;
    name: string;
    key: string;
    active: boolean;
    image: string | null;
    created: string;
    last_updated: string;
    parent_id: number | null;
    types: any[];
    created_at: string;
    updated_at: string;
    parent?: ProductType;
    children?: ProductType[];
    products?: Product[];
}

export interface Favorite {
    id: number;
    user_id: number;
    product_id: number;
    created_at: string;
    updated_at: string;
    user?: User;
    product?: Product;
}

export interface RecentSearch {
    id: number;
    user_id: number;
    query: string;
    created_at: string;
    updated_at: string;
    user?: User;
}

export type BreadcrumbItemType = BreadcrumbItem;
