<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Event" />

        <div class="flex items-center justify-center min-h-[80vh] text-pink-500">
            Single Event
        </div>
    </AuthenticatedLayout>
</template>
