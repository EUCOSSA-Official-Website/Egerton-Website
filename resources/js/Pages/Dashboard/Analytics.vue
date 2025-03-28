<script setup>
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import { ref, onMounted } from 'vue';
    import { router } from '@inertiajs/vue3';
    import DataTable from 'datatables.net-vue3';
    import DataTablesLib from 'datatables.net';
    import 'datatables.net-dt';

    DataTable.use(DataTablesLib);

    const props = defineProps({
        feedback: Array,
        users: Array
    });

    // Dropdown visibility state
    const showDropdown = ref(false);

    // Function to generate export URLs dynamically
    const exportUrl = (type) => route('dashboard.analytics.export-users', { type });

    // Format the date column
    const formatDate = (dateString) => {
        if (dateString === null) {
            return `<div class="text-red-500 text-bold">unregistered</div>`;
        }
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const month = months[date.getMonth()];
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    };

    // DataTable columns for users
    const columns2 = [
        {
            title: "#",
            data: null,
            render: (data, type, row, meta) => meta.row + 1,
        },
        { title: "Name", data: "name" },
        { title: "Email", data: "email" },
        { title: "Mobile", data: "mobile" },
        { title: "Registration Status", data: "registered", render: (data) => formatDate(data) },
    ];

    // DataTable columns for feedback
    const columns = [
        { title: "Name", data: "name" },
        { title: "Email", data: "email" },
        {
            title: "Message",
            data: "message",
            render: (data) => `<div class="max-h-[8rem] overflow-y-auto">${data}</div>`
        },
        {
            title: "Time",
            data: "created_at",
            render: (data) => formatDate(data)
        },
        {
            title: "Status",
            data: "read_at",
            orderable: false,
            render: (data, type, row) => {
                if (data) {
                    return `<span class="text-green-600 font-bold">Read</span>`;
                } else {
                    return `
                        <button 
                            class="mark-as-read-btn bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-700"
                            data-id="${row.id}">
                            Mark as Read
                        </button>`;
                }
            }
        }
    ];

    const tableOptions = {
        paging: true,
        searching: true,
        ordering: false,
        pageLength: 10,
        lengthChange: true,
        dom: "lfrtip",
    };

    onMounted(() => {
        document.addEventListener('click', function (event) {
            const target = event.target;
            if (target && target.classList.contains('mark-as-read-btn')) {
                const feedbackId = target.getAttribute('data-id');
                if (feedbackId) {
                    router.put(route('dashboard.analytics.seen', feedbackId), {}, {
                        preserveScroll: true,
                        onSuccess: () => {
                            // Optional: add toast or visual feedback
                            console.log(`Feedback ${feedbackId} marked as read.`);
                        }
                    });
                }
            }
        });
    });
</script>

<template>
    <Dashboard>
        <!-- Feedback Table -->
        <div>
            <h1 class="mx-auto text-3xl text-start mb-4">User Feedback</h1>
            <DataTable
                :data="feedback"
                :columns="columns"
                :options="tableOptions"
                class="table-auto border-collapse border border-gray-300 w-full text-left"
            />
        </div>

        <!-- Users Table with Export Buttons -->
        <div class="relative">
            <h1 class="mx-auto text-3xl text-start mb-4">Site Users</h1>
            
            <!-- Export Button -->
            <div class="relative inline-block text-left mb-4">
                <button @click="showDropdown = !showDropdown"
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700 flex items-center">
                    <i class="fas fa-download mr-1"></i> Export
                    <i :class="showDropdown ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas ml-2"></i>
                </button>

                <!-- Dropdown Menu -->
                <div v-if="showDropdown" class="absolute left-0 mt-2 w-32 bg-white border rounded shadow-md">
                    <a :href="exportUrl('csv')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">CSV</a>
                    <a :href="exportUrl('pdf')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">PDF</a>
                    <a :href="exportUrl('xlsx')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Excel</a>
                </div>
            </div>

            <!-- Users Table -->
            <DataTable
                :data="users"
                :columns="columns2"
                :options="tableOptions"
                class="table-auto border-collapse border border-gray-300 w-full text-left"
            />
        </div>
    </Dashboard>
</template>
