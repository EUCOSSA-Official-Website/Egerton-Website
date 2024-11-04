<template>
    <AuthenticatedLayout>

        <Head title="Admin" />

        <section>

            <header class="text-center py-5 bg-blue-700 text-white">
                <h1 class="font-bold text-4xl">Dashboard</h1>
                <p class="text-2xl font-normal mb-0">
                    All Admin Functions Are Here!
                </p>
            </header>

            <div class="grid grid-cols-12 min-h-[60vh] py-5">                

                <div class="overflow-x-auto col-span-12 lg:col-span-8 ml-2">
                    <slot />
                </div>

                <div class="ml-2 lg:ml-0 mt-4 lg:mt-0 col-span-12 lg:col-span-3 lg:col-start-10 bg-slate-300 py-5 max-h-[50vh]">

                    <Link :href="route('speakers')" class="submit-button w-fit ml-4 my-3 block">
                        Speakers
                    </Link>

                    <Link :href="route('events.create')" class="submit-button w-fit ml-4 my-3 block">
                        Post An Event
                    </Link>

                    <Link :href="route('finances')" class="submit-button w-fit ml-4 my-3 block">
                        Club Finances
                    </Link>

                    <Link :href="route('attendees')" class="submit-button w-fit ml-4 my-3 block">
                        Event Attendees
                    </Link>
                </div>

            </div>
            
        </section>         
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link, Head } from '@inertiajs/vue3';

    defineProps({
        'speakers': Array
    })

</script>
