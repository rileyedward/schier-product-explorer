<script setup lang="ts">
import { Product, Favorite } from '@/types';
import { ref } from 'vue';
import ProductBanner from '@/components/products/product-banner.vue';
import ProductInfoModal from '@/components/products/product-info-modal.vue';
import { useForm } from '@inertiajs/vue3';
import { RefreshCw } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';

interface Props {
    products: Product[];
    favorites: Favorite[];
}

defineProps<Props>();

const productSync = useForm({});

const selectedProduct = ref<Product | null>(null);
const isModalOpen = ref<boolean>(false);

const handleProductClick = (product: Product) => {
    selectedProduct.value = product;
    isModalOpen.value = true;
};
</script>

<template>
    <div v-if="products.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <product-banner
            v-for="product in products"
            :key="product.id"
            :product="product"
            :favorites="favorites"
            class="h-full"
            @click="handleProductClick(product)"
        />
    </div>

    <div v-else class="flex flex-col items-center justify-center p-8 bg-muted rounded-lg">
        <p class="text-lg font-medium mb-4">No products exist. Please sync products to get started.</p>
        <Button @click="productSync.post(route('products.sync'))" class="flex items-center">
            <RefreshCw class="mr-2 h-4 w-4" />
            <span>Sync Products</span>
        </Button>
    </div>

    <product-info-modal
        v-model:is-open="isModalOpen"
        :selected-product="selectedProduct"
        :favorites="favorites"
    />
</template>
