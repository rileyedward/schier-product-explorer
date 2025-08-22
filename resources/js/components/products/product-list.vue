<script setup lang="ts">
import { Product, Favorite } from '@/types';
import { ref } from 'vue';
import ProductBanner from '@/components/products/product-banner.vue';
import ProductInfoModal from '@/components/products/product-info-modal.vue';

interface Props {
    products: Product[];
    favorites: Favorite[];
}

defineProps<Props>();

const selectedProduct = ref<Product | null>(null);
const isModalOpen = ref<boolean>(false);

const handleProductClick = (product: Product) => {
    selectedProduct.value = product;
    isModalOpen.value = true;
};
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <product-banner
            v-for="product in products"
            :key="product.id"
            :product="product"
            :favorites="favorites"
            class="h-full"
            @click="handleProductClick(product)"
        />
    </div>

    <product-info-modal
        v-model:is-open="isModalOpen"
        :selected-product="selectedProduct"
        :favorites="favorites"
    />
</template>
