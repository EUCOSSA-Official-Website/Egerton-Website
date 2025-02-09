<script setup>
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import { Link, useForm } from '@inertiajs/vue3';
    import DataTable from 'datatables.net-vue3';
    import DataTablesLib from 'datatables.net';
    import 'datatables.net-dt';

    DataTable.use(DataTablesLib);

    const props = defineProps({
        feedback: Array,
        users: Array
    });

    const formatDate = (dateString) => {
        if(dateString === null){
            return `<div class="text-red-500 text-bold">unregistered</div>`;
        }
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const month = months[date.getMonth()];
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    };

    const markAsRead = (id) => {
        const form = useForm({});
        form.put(route('dashboard.analytics.seen', { id }), {
            preserveScroll: true,
            onSuccess: () => {
                // Optional: Add a success callback if needed
            }
        });
    };

    const columns2 = [
        {
            title: "#", // Number column title
            data: null, // We don't bind it to any data, this will be handled by render
            render: (data, type, row, meta) => meta.row + 1, // Row numbering (starts from 1)
        },
        { title: "Name", data: "name" },
        { title: "Email", data: "email" },
        { title: "mobile", data: "mobile" },
        { title: "Registration Status", data: "registered", render: (data) => formatDate(data) },
    ];
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
                return `
                    <button @click.prevent="() => markAsRead(${row.id})" 
                            class="text-white font-bold bg-blue-500 px-2 py-1 rounded hover:bg-blue-700">
                        ${!data ? "Mark as Read" : "Read"}
                    </button>`;
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
</script>

<template>
    <Dashboard>
        <div>
            <h1 class="mx-auto text-3xl text-start mb-4">User Feedback</h1>
            <DataTable
                :data="feedback"
                :columns="columns"
                :options="tableOptions"
                class="table-auto border-collapse border border-gray-300 w-full text-left"
            />
        </div>

        <div>
            <h1 class="mx-auto text-3xl text-start mb-4">Sites Users</h1>
            <DataTable
                :data="users"
                :columns="columns2"
                :options="tableOptions"
                class="table-auto border-collapse border border-gray-300 w-full text-left"
            />
        </div>
    </Dashboard>
</template>
