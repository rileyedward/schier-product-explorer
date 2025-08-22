<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Favorite, Product } from '@/types';
import { Heart } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    product: Product;
    favorites?: Favorite[];
}

interface Emits {
    (e: 'click', product: Product): void;
}

const props = defineProps<Props>();
const emit = defineEmits<Emits>();

const isFavorite = computed(() => {
    if (!props.favorites) return false;
    return props.favorites.some((favorite) => favorite.product_id === props.product.id);
});

const handleClick = () => {
    emit('click', props.product);
};
</script>

<template>
    <card class="w-full cursor-pointer transition-all hover:scale-105 hover:bg-muted/50" @click="handleClick">
        <card-header class="flex flex-row items-center gap-4">
            <avatar class="size-16">
                <avatar-image v-if="product.images?.primary?.md" :src="product.images.primary.md" :alt="product.name" />
                <avatar-fallback v-else class="text-lg">{{ product.short_name.substring(0, 2) }}</avatar-fallback>
            </avatar>
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <card-title>{{ product.short_name }}</card-title>
                    <heart v-if="isFavorite" class="h-5 w-5 text-red-500" />
                </div>
                <card-description>{{ product.name }}</card-description>
            </div>
        </card-header>
        <card-content v-if="product.short_description">
            <p class="text-sm text-muted-foreground">{{ product.short_description }}</p>
        </card-content>
        <card-content class="flex flex-row gap-4 text-sm">
            <div v-if="product.part_number" class="flex flex-col">
                <span class="font-semibold">Part Number</span>
                <span>{{ product.part_number }}</span>
            </div>
            <div v-if="product.price?.list" class="flex flex-col">
                <span class="font-semibold">Price</span>
                <span>${{ product.price.list }}</span>
            </div>
        </card-content>
    </card>
</template>
