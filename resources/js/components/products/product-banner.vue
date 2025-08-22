<script setup lang="ts">
import { Product } from '@/types';

interface Props {
    product: Product;
}

defineProps<Props>();
</script>

<template>
    <div>
        {{ product.short_name }} - {{ product.name }}
    </div>
</template>
