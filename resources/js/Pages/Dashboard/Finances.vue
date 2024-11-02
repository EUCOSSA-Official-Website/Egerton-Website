<template>
    <AuthenticatedLayout>
        <Head title="Finances" />

        <header class="bg-blue-700 text-white py-8 text-3xl text-center">
            <Link :href="route('dashboard')" class="underline">Dashboard</Link> → <Link class="underline">Finances</Link>
        </header>

        <div class="flex min-h-[70vh] items-center justify-center text-center text-pink-500 text-3xl">
            This is the Finances Page!
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import { Head, Link } from '@inertiajs/vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>
