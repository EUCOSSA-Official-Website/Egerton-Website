<template>

    <AuthenticatedLayout>
        <head title="payments"/>

        <section class="min-h-[100vh]">
            <h1 class="text-2xl font-bold ms-2"> All Events</h1>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <EventCard v-for="event in events" :key="event.id" :event="event" class=""/>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import EventCard from '@/Components/EventCard.vue';

    defineProps({
        'events': Array
    })
</script>
