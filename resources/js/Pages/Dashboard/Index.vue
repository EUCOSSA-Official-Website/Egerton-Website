<template>
    <AuthenticatedLayout>

        <section>

            <div class="text-center py-5">
                <h1 class="font-bold text-4xl">Dashboard</h1>
                <p class="text-2xl font-normal text-gray-500 mb-0">
                    All Admin Functions Are Here!
                </p>
            </div>

            <div class="grid grid-cols-12 min-h-[60vh] py-5">
                
                <div class="col-span-8">
                    <button class="rounded-md w-full bg-blue-800">
                        Post an event. 
                    </button>
                </div>

                <div class="col-span-3 col-start-10 bg-slate-300 py-5">

                    <Link :href="route('events.create')" class="submit-button w-fit ml-4 my-3">
                        Post An Event
                    </Link>
                </div>
            </div>
        </section>         
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Link } from '@inertiajs/vue3';
</script>
