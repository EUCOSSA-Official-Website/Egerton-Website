<template>
    <AuthenticatedLayout>

        <Head title="Admin" />

        <section>

            <div class="text-center py-5">
                <h1 class="font-bold text-4xl">Dashboard</h1>
                <p class="text-2xl font-normal text-gray-500 mb-0">
                    All Admin Functions Are Here!
                </p>
            </div>

            <div class="grid grid-cols-12 min-h-[60vh] py-5">                

                <div class="overflow-x-auto col-span-8 ml-2">

                    <h1 class="mx-auto text-2xl text-center">Speakers</h1>
                    <table class="min-w-full bg-white border border-gray-800">
                        <thead class="bg-gray-100 sticky top-0 z-10">
                            <tr class="bg-gray-100 text-left text-gray-600 font-semibold">
                                <th class="py-1 px-2 border-b border-slate-800">Name</th>
                                <th class="py-1 px-2 border-b border-slate-800">Year of Study</th>
                                <th class="py-1 px-2 border-b border-slate-800">Topic</th>
                                <th class="py-1 px-2 border-b border-slate-800">Email</th>
                                <th class="py-1 px-2 border-b border-slate-800">View</th>
                            </tr>
                        </thead>
                        <tbody class="max-h-[20vh]">
                            <tr v-for="(speaker, index) in speakers" :key="index" class="hover:bg-gray-50"
                                :class="index % 2 === 0 ? 'bg-gray-100' : 'bg-white'">
                                <td class="py-3 px-1 whitespace-nowrap border border-slate-800">{{ speaker.name }}</td>
                                <td class="py-3 px-1 border border-slate-800">{{ speaker.year_of_study }}</td>
                                <td class="py-3 px-1 border border-slate-800">{{ speaker.topic }}</td>
                                <td class="py-3 px-1 border border-slate-800">{{ speaker.email }}</td>
                                <td class="py-3 px-1 border border-slate-800 text-center text-white font-bold bg-blue-500 mx-2 my-2">
                                    <Link :href="route('call-for-speakers.show', {call_for_speaker: speaker.id})">View</Link>                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-span-3 col-start-10 bg-slate-300 py-5 max-h-[50vh]">

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
    import { Link, Head } from '@inertiajs/vue3';

    defineProps({
        'speakers': Array
    })

</script>
