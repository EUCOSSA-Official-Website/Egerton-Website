<script setup>
    import { ref, computed, onMounted } from 'vue';
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import DataTable from 'datatables.net-vue3';
    import DataTablesLib from 'datatables.net';
    import 'datatables.net-dt'; // Optional styling for DataTables

    DataTable.use(DataTablesLib);

    const props = defineProps({
        events: Object, // Events are grouped by event_id
    });

    const showDropdown = ref(false);

    const selectedEventId = ref(null);

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

    // Generate Export URLs dynamically
    const exportUrl = (format) => {
        return `/dashboard/event/${selectedEventId.value}/export/${format}`;
    };

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

            <!-- Export Button Group -->
            <div v-if="selectedEventId" class="relative inline-block text-left">
                <button @click="showDropdown = !showDropdown" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700 flex items-center"
                >
                    <i class="fas fa-download mr-1"></i> Export
                    <i :class="showDropdown ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas ml-2"></i>
                </button>

                <!-- Dropdown Menu -->
                <div v-if="showDropdown" class="absolute left-0 mt-2 w-32 bg-white border rounded shadow-md"
                >
                    <a :href="exportUrl('csv')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">CSV</a>
                    <a :href="exportUrl('pdf')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">PDF</a>
                    <a :href="exportUrl('xlsx')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Excel</a>
                </div>
            </div>


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
