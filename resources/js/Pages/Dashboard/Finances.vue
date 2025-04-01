<template>
    <Dashboard>
        <div>
            <h1 class="mx-auto text-2xl text-center font-bold">Balances</h1>

            <!-- Latest Balance Display -->
            <input
                type="text"
                class="border px-3 py-2 w-full mb-4"
                v-model="latestBalance"
                readonly
                placeholder="Balance not available"
            />

            <!-- Fetch Balance Button -->
            <button
                @click="fetchLatestBalance"
                class="block bg-blue-700 text-white rounded-sm px-3 py-1 my-4"
            >
                Check Latest Balance
            </button>

            <!-- Transaction History Table -->
            <DataTable
                :data="balances"
                :columns="columns"
                :options="{
                    paging: true,
                    searching: true,
                    ordering: true,
                    pageLength: 10,
                    lengthChange: true,
                    dom: 'lfrtip',
                    order: [] // Disables default sorting
                }"
                class="table-auto border-collapse border border-gray-300 w-full text-left"
            />
        </div>
    </Dashboard>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import axios from 'axios';
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import DataTable from 'datatables.net-vue3';
    import DataTablesCore from 'datatables.net-bs5';
    import 'datatables.net-bs5/css/dataTables.bootstrap5.css'; // ✅ Theming


    DataTable.use(DataTablesCore);

    // Latest balance state
    const latestBalance = ref('Fetching balance...');
    let attempts = 0;
    let interval = null;

    // Function to fetch the latest balance
    async function getLatestBalance() {
        try {
            const response = await axios.get('/latest-balance');
            if (response.data.balance) {
                latestBalance.value = response.data.balance;
                return true; // Indicates that balance is found
            }
        } catch (error) {
            console.error("Error fetching balance:", error);
        }
        return false; // Indicates that balance is not yet available
    }

    // Function to trigger balance check and poll for 5 times
    async function fetchLatestBalance() {
        try {
            await axios.post('/balance'); // Trigger MPESA balance check
            latestBalance.value = 'Fetching balance...';

            let attempts = 0;
        
            const interval = setInterval(async () => {
                attempts++; // Increment first to avoid extra loop

                const found = await getLatestBalance();
                if (found || attempts >= 5) {
                    clearInterval(interval); // Stop polling if balance is found or after 5 attempts
                }
            }, 5000);
        } catch (error) {
            console.error("Error initiating balance check:", error);
            latestBalance.value = 'Error fetching balance';
        }
    }


    // Poll for balance on page load every 5 seconds
    onMounted(() => {
        interval = setInterval(async () => {
            attempts++;
            const found = await getLatestBalance();
            if (found || attempts >= 5) {
                clearInterval(interval); // Stop polling if balance is found or after 5 attempts
            }
        }, 5000);
    });

    // Receiving The Balances Object
    defineProps({
        balances: Array,
    });

    // Define DataTable columns
    const columns = [
        { title: "ID", data: "id" },
        { title: "Channel", data: "gateway" },
        {
            title: "Time",
            data: "retrieved_at",
            render: {
                display: (data) => formattedDate(data), // what shows in the UI
                sort: (data) => new Date(data).getTime(), // what DataTables uses to sort
            }
        },
        { title: "Balance", data: "balance" },
    ];

    // Format Date
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

<style>
    /* ✅ Tailwind overrides to control Bootstrap pagination */
    .pagination {
    all: unset;
    display: flex;
    gap: 0.5rem;
    margin-top: 1.5rem;
    }

    .pagination li {
    list-style: none;
    }

    .pagination .page-item {
    display: inline-block;
    }

    .pagination .page-link {
    @apply px-3 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-100;
    }

    /* Active page */
    .pagination .active .page-link {
    @apply bg-blue-500 text-white border-blue-500;
    }
</style>
