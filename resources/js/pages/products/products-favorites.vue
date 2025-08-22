<script setup lang="ts">
import ProductFilter from '@/components/products/product-filter.vue';
import ProductList from '@/components/products/product-list.vue';
import ProductSearch from '@/components/products/product-search.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, Favorite, Product, ProductType, RecentSearch } from '@/types';
import { Head as InertiaHead, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

interface Props {
    productTypes: ProductType[];
    products: Product[];
    favorites: Favorite[];
    recentSearches: RecentSearch[];
    search?: string;
    filter?: string;
}

const props = defineProps<Props>();

const searchQuery = ref<string>(props.search || '');
const isSearching = ref<boolean>(false);

const filterQuery = ref<string>(props.filter || '');

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('products.index'),
    },
    {
        title: 'Favorites',
        href: route('products.favorites'),
    },
];

const handleQueryChange = (type: 'search' | 'filter', value: string) => {
    isSearching.value = true;

    const timeoutId = setTimeout(() => {
        router.get(
            route('products.index'),
            {
                search: type === 'search' ? value : searchQuery.value,
                filter: type === 'filter' ? value : filterQuery.value,
            },
            {
                preserveState: true,
                preserveScroll: true,
                only: type === 'search' ? ['products', 'recentSearches'] : ['products'],
                onSuccess: () => {
                    isSearching.value = false;
                },
                onError: () => {
                    isSearching.value = false;
                },
            },
        );
    }, 300);

    return () => clearTimeout(timeoutId);
};

watch(searchQuery, (value) => handleQueryChange('search', value));
watch(filterQuery, (value) => handleQueryChange('filter', value));
</script>

<template>
    <inertia-head title="Products" />

    <app-layout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <product-search v-model="searchQuery" :recent-searches="recentSearches" @search="(value) => handleQueryChange('search', value)" />

            <product-filter v-model="filterQuery" :product-types="productTypes" @filter="(value) => handleQueryChange('filter', value)" />

            <product-list v-if="!isSearching" :products="products" :favorites="favorites" />

            <!-- Loading Spinner -->
            <div v-else class="flex justify-center py-4">
                <div class="h-6 w-6 animate-spin rounded-full border-2 border-primary border-t-transparent"></div>
            </div>
        </div>
    </app-layout>
</template>
