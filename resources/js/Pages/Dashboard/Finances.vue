<template>
    <Dashboard>
        <div>
            <h1 class="mx-auto text-2xl text-center font-bold">Balances</h1>
            <Link
                @click="fetchLatestBalance"
                :href="route('balance')"
                method="post"
                as="button"
                class="block bg-blue-700 text-white rounded-sm px-3 py-1 my-4"
            >
                Check Latest Balance
            </Link>
            <DataTable
                :data="balances"
                :columns="columns"
                :options="{
                    paging: true,
                    searching: true,
                    ordering: false,
                    pageLength: 10,
                    lengthChange: true,
                    dom: 'lfrtip',
                }"
                class="table-auto border-collapse border border-gray-300 w-full text-left"
            />
        </div>
    </Dashboard>
</template>

<script setup>
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import { Link } from '@inertiajs/vue3';
    import { router } from '@inertiajs/vue3';
    import DataTable from 'datatables.net-vue3';
    import DataTablesLib from 'datatables.net';
    import 'datatables.net-dt'; // Optional styling for DataTables

    DataTable.use(DataTablesLib);

    function fetchLatestBalance() {
        setTimeout(() => {
            router.visit(route('dashboard.finances'), { method: 'get', preserveState: true });
        }, 4000);
    }

    // Receiving The Balances Object
    defineProps({
        balances: Array,
    });

    // Define the DataTable columns
    const columns = [
        {title: "id", data: "id"},
        { title: "Channel", data: "gateway" },
        { 
            title: "Time", 
            data: "retrieved_at", 
            render: (data) => formattedDate(data), 
        },
        { title: "Balance", data: "balance" },
    ];

    // Formatted Date
    const formattedDate = (transactionDate) => {
        const date = new Date(transactionDate);
        return `${date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        })} at ${date.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true,
        })}`;
    };

</script>
