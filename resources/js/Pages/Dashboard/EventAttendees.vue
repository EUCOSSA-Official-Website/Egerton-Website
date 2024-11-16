<script setup>
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';

    defineProps({
        events: Object
    })

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
        <!-- <div class="min-h-[80vh] flex justify-center items-center text-pink-600 text-3xl">
            Event Attendees Page. 
        </div> -->

        <div>
            <table class="table-auto border-collapse border border-gray-300 w-full text-left">
            <thead>
                <tr>
                <th class="border border-gray-300 px-2 py-2">ID</th>
                <th class="border border-gray-300 px-2 py-2">User ID</th>
                <th class="border border-gray-300 px-2 py-2">Event ID</th>
                <th class="border border-gray-300 px-2 py-2">Receipt Number</th>
                <th class="border border-gray-300 px-2 py-2">Amount Paid</th>
                <th class="border border-gray-300 px-2 py-2">Paid At</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="event in events" :key="event.id">
                <td class="border border-gray-300 px-2 py-2">{{ event.id }}</td>
                <td class="border border-gray-300 px-2 py-2">{{ event.user_id }}</td>
                <td class="border border-gray-300 px-2 py-2">{{ event.event_id }}</td>
                <td class="border border-gray-300 px-2 py-2">{{ event.receipt_number }}</td>
                <td class="border border-gray-300 px-2 py-2">{{ event.amount_paid }}</td>
                <td class="border border-gray-300 px-2 py-2">{{ formatDate(event.updated_at) }}</td>
                </tr>
            </tbody>
            </table>
        </div>
    </Dashboard>
</template>
