<template>
    <Head title="speaker" />

    <AuthenticatedLayout>

        <div class="text-5xl my-4 text-center text-indigo-700">
            <Link :href="(route('dashboard'))">Dashboard</Link> → <Link>Speaker</Link>
        </div>

        <div class="min-h-[80vh] grid grid-cols-12">
            <div class="col-span-8">
                <ol class="flex flex-col">
                    <li>Name: {{ speaker.name }}</li>
                    <li>Year Of Study: {{ speaker.year_of_study }}</li>
                    <li>Other Year: {{ speaker.other_year ?? null}}</li>
                    <li>Topic: {{ speaker.topic }}</li>
                    <li>Description: {{ speaker.description }}</li>
                    <li>Stack: {{ speaker.stack }}</li>
                    <li>Skill: {{ speaker.skill }}</li>
                    <li>Phone: {{ speaker.phone }}</li>
                    <li>Time: {{ speaker.created_at }}</li>
                </ol>
                
            </div>

            <div class="col-span-12 sm:col-span-4 bg-gray-400 max-h-[50vh]"></div>
     
        </div>
    </AuthenticatedLayout>

</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link } from '@inertiajs/vue3';

    defineProps({
        speaker: Object
    });
</script>
