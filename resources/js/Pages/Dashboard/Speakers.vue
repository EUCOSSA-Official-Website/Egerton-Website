<script setup>
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import { Link } from '@inertiajs/vue3';
    import DataTable from 'datatables.net-vue3';
    import DataTablesLib from 'datatables.net';
    import 'datatables.net-dt'; // Optional styling for DataTables

    DataTable.use(DataTablesLib);

    defineProps({
        speakers: Array,
    });

    // Define the DataTable columns
    const columns = [
        { title: "Name", data: "name" },
        { title: "Year of Study", data: "year_of_study" },
        {
            title: "Topic",
            data: "topic",
            render: (data, type, row) => {
                // Show topic with approved/disapproved badge
                const approvedBadge = row.approved
                    ? `<div class="absolute top-0 right-0 text-white bg-yellow-500 text-xs rounded px-2">Approved</div>`
                    : row.disapproved
                    ? `<div class="absolute top-0 right-0 text-white bg-black text-xs rounded px-2">Disapproved</div>`
                    : "";

                return `<div class="relative pt-2">${data || ""}${approvedBadge}</div>`;
            },
        },
        {
            title: "Email",
            data: "email",
            render: (data, type, row) => {
                // Show email with "Pending Approval" badge if not approved/disapproved
                const pendingBadge =
                    row.approved === null && row.disapproved === null
                        ? `<div class="absolute top-0 right-0 text-white bg-red-700 rounded text-xs px-2">Pending Approval!</div>`
                        : "";

                return `<div class="relative py-3 px-1">${data || ""}${pendingBadge}</div>`;
            },
        },
        {
            title: "View",
            data: null,
            orderable: false,
            render: (data, type, row) => {
                // Add a FontAwesome icon for the "View" link
                return `<a href="${route('call-for-speakers.show', { call_for_speaker: row.id })}" 
                           class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-eye"></i>
                        </a>`;
            },
        },
    ];

    // Options for DataTables
    const tableOptions = {
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 10,
        lengthChange: true,
        dom: "lfrtip",
    };
</script>

<template>
    <Dashboard>
        <div>
            <h1 class="mx-auto text-2xl text-center font-bold">Speakers</h1>
            <DataTable
                :data="speakers"
                :columns="columns"
                :options="tableOptions"
                class="table-auto border-collapse border border-gray-300 w-full text-left"
            />
        </div>
    </Dashboard>
</template>
