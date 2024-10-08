<template>

    <Head title="Payments" />

    <AuthenticatedLayout>
        <!-- Welcome Section -->
        <section class="min-h-[80vh] relative bg-gray-50">
            <h1 class="text-5xl text-pink-500">This is the payment section. </h1>
        </section>

        <!-- Other Random Section -->
        <div class="min-h-[20vh]" id="welcome">
            <p>Hello World</p>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
</script>

<style scoped>

#welcome {
    background-color: #00028C;
}
</style>
