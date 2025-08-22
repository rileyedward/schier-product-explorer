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

export interface FuturePrice {
    object: string;
    activeAt: string | null;
}

export interface Processing {
    lead_time: number;
    threshold: number;
}

export interface BaseModel {
    is_base_model: boolean;
    base_part_number: string;
}

export interface InstallationDimension {
    delta_dimension: Measurement;
    neck_line_height: Measurement;
}

export interface InstallationDimensions {
    object: string;
    standard: InstallationDimension;
    metric: InstallationDimension;
}

export interface DocumentLibrary {
    object: string;
    pdf: string | null;
    dwg: string | null;
}

export interface InstallationGuide extends DocumentLibrary {
    pdf_french: string | null;
    pdf_spanish: string | null;
}

export interface ListObject {
    object: string;
    data: any[];
}

export interface Product {
    id: number;
    object: string;
    url: string;
    name: string;
    short_name: string;
    created: string;
    updated: string;
    types: string[];
    part_number: string;
    base_model: BaseModel;
    store_id: string;
    shipping_group: string;
    active: boolean;
    visible_on_store: boolean;
    description: string;
    short_description: string;
    market_specific_description: string | null;
    website_url: string;
    images: ProductImageLibrary;
    processing: Processing;
    price: ProductPrice;
    future_price: FuturePrice;
    base_dimensions: DimensionSet;
    shipping_dimensions: DimensionSet;
    case_shipping_dimensions: DimensionSet[] | [];
    case_quantity: number | null;
    manway_access_ports: number;
    units_in_series: any[];
    installation_dimensions: InstallationDimensions;
    options: ListObject;
    certifications: any[];
    barcodes: any[] | null;
    spec_sheet: DocumentLibrary;
    installation_guide: InstallationGuide;
    revit: string | null;
    owners_manual: string | null;
    csi_masterspec: string | null;
}

export type BreadcrumbItemType = BreadcrumbItem;
