<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head as InertiaHead } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('products.index')
    },
    {
        title: 'Favorites',
        href: route('products.favorites'),
    },
];
</script>

<template>
    <inertia-head title="Products" />

    <app-layout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <h1>Favorites!</h1>
        </div>
    </app-layout>
</template>
