<script setup>
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        feedback: Array
    });

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const month = months[date.getMonth()]; // Get the 3-letter month abbreviation        
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }
</script>

<template>
    <Dashboard>
        <div>
            <h1 class="mx-auto text-3xl text-start mb-4">User Feedback</h1>
            <table class="min-w-full bg-white border border-gray-800">
                <thead class="bg-gray-100 sticky top-0 z-10">
                    <tr class="bg-gray-100 text-left text-gray-600 font-semibold">
                        <th class="py-1 px-2 border-b border-slate-800">Name</th>
                        <th class="py-1 px-2 border-b border-slate-800">Email</th>
                        <th class="py-1 px-2 border-b border-slate-800">Year</th>
                        <th class="py-1 px-2 border-b border-slate-800">Time</th>
                        <th class="py-1 px-2 border-b border-slate-800">Status</th>
                    </tr>
                </thead>
                <tbody class="max-h-[20vh]">
                    <tr v-for="(feedback, index) in feedback" :key="index" class="hover:bg-gray-50"
                        :class="index % 2 === 0 ? 'bg-gray-100' : 'bg-white'">
                        <td class="py-3 px-1 border border-slate-800">{{ feedback.name }}</td>
                        <td class="py-3 px-1 border border-slate-800">{{ feedback.email }}</td>
                        <td class="py-3 px-1 border border-slate-800 w-64 ">
                            <div class="max-h-[8rem] overflow-y-auto">
                                {{ feedback.message }}
                            </div>
                        </td>
                        <td class="py-3 px-1 border border-slate-800">{{ formatDate(feedback.created_at) }}</td>
                        <td class="py-3 px-1 border border-slate-800 text-center text-white font-bold bg-blue-500 mx-2 my-2">
                            <Link :href="route('dashboard.analytics.seen', {id: feedback.id})" as="button" method="put">{{ !feedback.read_at ? "Mark as Read" : "Read"}}</Link>                                    
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Dashboard>
</template>
