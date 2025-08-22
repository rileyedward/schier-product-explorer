<script setup lang="ts">
import { Product } from '@/types';
import ProductBanner from '@/components/products/product-banner.vue';

interface Props {
    products: Product[];
}

defineProps<Props>();
</script>

<template>
    <div>
        <product-banner v-for="product in products" :key="product.id" :product="product" />
    </div>
</template>
