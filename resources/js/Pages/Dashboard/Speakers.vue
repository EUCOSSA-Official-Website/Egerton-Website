<script setup>
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import { Link } from '@inertiajs/vue3';

    defineProps({
        'speakers': Array
    }) 
</script>

<template>
    <Dashboard>
        <div>
            <h1 class="mx-auto text-2xl text-center font-bold">Speakers</h1>
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
                        <td class="py-3 px-1 border border-slate-800">
                            <div class="relative pt-2">
                                {{ speaker.topic }}
                                <div v-if="speaker.approved" class="absolute top-0 right-0 text-white bg-yellow-500 text-xs rounded px-2">Approved</div>
                                <div v-if="speaker.disapproved" class="absolute top-0 right-0 text-white bg-black text-xs rounded px-2">Disapproved</div>
                            </div>
                        </td>
                        <td class="border border-slate-800">
                            <div class="relative py-3 px-1">
                                {{ speaker.email }}
                                <div v-if="speaker.approved === null && speaker.disapproved === null" class="absolute top-0 right-0 text-white bg-red-700 rounded text-xs px-2">
                                    Pending Approval!
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-1 border border-slate-800 text-center text-white font-bold bg-blue-500 mx-2 my-2">
                            <Link :href="route('call-for-speakers.show', {call_for_speaker: speaker.id})">View</Link>                                    
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Dashboard>
</template>
