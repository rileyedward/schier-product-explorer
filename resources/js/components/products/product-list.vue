<script setup lang="ts">
import { Product } from '@/types';
import ProductBanner from '@/components/products/product-banner.vue';

interface Props {
    products: Product[];
}

defineProps<Props>();
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <product-banner
            v-for="product in products"
            :key="product.id"
            :product="product"
            class="h-full"
        />
    </div>
</template>
