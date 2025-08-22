<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, ProductType, Product, Favorite, RecentSearch } from '@/types';
import { Head as InertiaHead, router } from '@inertiajs/vue3';
import ProductList from '@/components/products/product-list.vue';
import ProductSearch from '@/components/products/product-search.vue';
import { ref, watch } from 'vue';

interface Props {
    productTypes: ProductType[];
    products: Product[];
    favorites: Favorite[];
    recentSearches: RecentSearch[];
    search?: string;
}

const props = defineProps<Props>();

const searchQuery = ref<string>(props.search || '');
const isSearching = ref<boolean>(false);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('products.index'),
    },
];

const handleSearch = (query: string) => {
    isSearching.value = true;

    const timeoutId = setTimeout(() => {
        router.get(
            route('products.index'),
            { search: query },
            {
                preserveState: true,
                preserveScroll: true,
                only: ['products', 'recentSearches'],
                onSuccess: () => {
                    isSearching.value = false;
                },
                onError: () => {
                    isSearching.value = false;
                }
            }
        );
    }, 300);

    return () => clearTimeout(timeoutId);
};

watch(searchQuery, handleSearch);
</script>

<template>
    <inertia-head title="Products" />

    <app-layout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <product-search
                v-model="searchQuery"
                :recent-searches="recentSearches"
                @search="handleSearch"
            />

            <div v-if="isSearching" class="flex justify-center py-4">
                <div class="animate-spin h-6 w-6 border-2 border-primary rounded-full border-t-transparent"></div>
            </div>
            <product-list v-else :products="products" />
        </div>
    </app-layout>
</template>
