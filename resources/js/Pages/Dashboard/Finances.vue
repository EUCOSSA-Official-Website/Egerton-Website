<template>
    <Dashboard>
        <div class="flex min-h-[70vh] items-center justify-center text-center text-pink-500 text-3xl">
            <div class="inline-block"> This is the Finances Page!</div>

            <Link :href="route('balance')" method='post' as='button' class="block bg-blue-700 text-white rounded">Check Balance</Link>
        </div>
    </Dashboard>
</template>

<script setup>
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import { Link } from '@inertiajs/vue3';
</script>
