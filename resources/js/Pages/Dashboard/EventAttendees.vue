<template>

    <Head title="Attendees" />

    <AuthenticatedLayout>

        <header class="bg-blue-700 text-white py-5 text-3xl text-center">
            <Link :href="route('dashboard')" class="underline">Dashboard</Link> → <Link class="underline">Attendees</Link>
        </header>        

        <div class="min-h-[80vh] flex justify-center items-center text-pink-600 text-3xl">
            Event Attendees Page. 
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';
</script>
