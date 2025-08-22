<script setup lang="ts">
import { Product } from '@/types';
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card';
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';

interface Props {
    product: Product;
}

defineProps<Props>();
</script>

<template>
    <card class="w-full hover:bg-muted/50 cursor-pointer hover:scale-105 transition-all">
        <card-header class="flex flex-row items-center gap-4">
            <avatar class="size-16">
                <avatar-image v-if="product.images?.primary?.md" :src="product.images.primary.md" :alt="product.name" />
                <avatar-fallback v-else class="text-lg">{{ product.short_name.substring(0, 2) }}</avatar-fallback>
            </avatar>
            <div>
                <card-title>{{ product.short_name }}</card-title>
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
