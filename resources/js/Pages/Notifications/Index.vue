<template>
    <AuthenticatedLayout>
        <Head title="Notifications"/>
        <div class="flex items-center justify-center min-h-[80vh]">
            <div class="py-8 px-4 shadow-2xl shadow-b border-black">
                Samuel Is The Best
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
</script>