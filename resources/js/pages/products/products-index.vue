<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, ProductType, Product, Favorite, RecentSearch } from '@/types';
import { Head as InertiaHead } from '@inertiajs/vue3';
import ProductList from '@/components/products/product-list.vue';

interface Props {
    productTypes: ProductType[];
    products: Product[];
    favorites: Favorite[];
    recentSearches: RecentSearch[];
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('products.index'),
    },
];
</script>

<template>
    <inertia-head title="Products" />

    <app-layout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <product-list :products="products" />
        </div>
    </app-layout>
</template>
