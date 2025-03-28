<script setup>
    import { ref, computed, onMounted } from 'vue';
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import DataTable from 'datatables.net-vue3';
    import DataTablesLib from 'datatables.net';
    import 'datatables.net-dt'; // Optional styling for DataTables

    DataTable.use(DataTablesLib);

    const props = defineProps({
        events: Object, // Events are grouped by event_id (passed as an object)
    });

    const selectedEventId = ref(null); // Holds selected event_id

    // Compute event names dynamically for buttons
    // const eventNames = computed(() =>
    //     Object.keys(props.events).map(eventId => ({
    //         id: eventId,
    //         name: props.events[eventId][0]?.event?.title || `Event ${eventId}`, // Fallback name
    //     }))
    // );

    // Compute event names dynamically for buttons in reverse order (latest first)
    const eventNames = computed(() =>
        Object.keys(props.events)
            .sort((a, b) => b - a) // Sort in descending order
            .map(eventId => ({
                id: eventId,
                name: props.events[eventId][0]?.event?.title || `Event ${eventId}`, // Fallback name
            }))
    );

    // Automatically select the first event when the component is mounted
    onMounted(() => {
        if (eventNames.value.length > 0) {
            selectedEventId.value = eventNames.value[0].id;
        }
    });

    // Filter data based on selected event_id
    const filteredEvents = computed(() => 
        selectedEventId.value ? props.events[selectedEventId.value] : []
    );

    const columns = [
        {
            title: "#",
            data: null,
            render: (data, type, row, meta) => meta.row + 1,
        },
        { title: "User ID", data: "user_id" },
        { title: "Preferred Name", data: "prefered_name" },
        { title: "Event ID", data: "event_id" },
        { title: "Receipt Number", data: "receipt_number" },
        { title: "Amount Paid", data: "amount_paid" },
        { 
            title: "Paid At",
            data: "updated_at",
            render: (data) => formatDate(data),
        },
    ];

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const month = months[date.getMonth()];
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    };
</script>

<template>
    <Dashboard>
        <div class="space-y-4">
            <!-- Event Filter Buttons -->
            <div class="flex flex-wrap gap-2">
                <button
                    v-for="event in eventNames"
                    :key="event.id"
                    @click="selectedEventId = event.id"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700"
                >
                    {{ event.name }}
                </button>
            </div>

            <!-- Display selected event name -->
            <h2 v-if="selectedEventId" class="text-lg font-semibold">
                Attendees for: {{ eventNames.find(e => e.id == selectedEventId)?.name }}
            </h2>

            <!-- Attendees Table -->
            <DataTable
                :data="filteredEvents"
                :columns="columns"
                :options="{
                    paging: true,
                    searching: true,
                    ordering: true,
                    pageLength: 10,
                    lengthChange: true,
                    dom: 'lfrtip',
                }"
                class="table-auto border-collapse border border-gray-300 w-full text-left"
            />
        </div>
    </Dashboard>
</template>
