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

            <!-- TEMP: remove after successful child-store C2B URL registration -->
            <button
                @click="registerC2bUrls"
                :disabled="registeringC2b"
                class="block bg-blue-700 text-white rounded-sm px-3 py-1 my-4 disabled:opacity-50"
            >
                {{ registeringC2b ? 'Registering…' : 'Register C2B URLs (temp)' }}
            </button>
            <pre
                v-if="c2bRegisterResponse"
                class="mb-4 overflow-x-auto whitespace-pre-wrap rounded border border-gray-300 bg-gray-50 p-3 text-sm"
            >{{ c2bRegisterResponse }}</pre>

            <!-- C2B Transaction History Table -->
            <DataTable
                :data="transactions"
                :columns="columns"
                :options="{
                    paging: true,
                    searching: true,
                    ordering: true,
                    pageLength: 10,
                    lengthChange: true,
                    dom: 'lfrtip',
                    order: []
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
    import 'datatables.net-bs5/css/dataTables.bootstrap5.css';

    DataTable.use(DataTablesCore);

    const latestBalance = ref('Fetching balance...');
    const registeringC2b = ref(false);
    const c2bRegisterResponse = ref('');
    let pollInterval = null;

    async function registerC2bUrls() {
        registeringC2b.value = true;
        c2bRegisterResponse.value = '';

        try {
            const response = await axios.post(route('payments.c2b.register'));
            c2bRegisterResponse.value = JSON.stringify(response.data, null, 2);
        } catch (error) {
            c2bRegisterResponse.value = JSON.stringify(
                error.response?.data ?? { message: error.message },
                null,
                2
            );
        } finally {
            registeringC2b.value = false;
        }
    }

    async function getLatestBalance() {
        try {
            const response = await axios.get('/latest-balance');
            if (response.data.balance !== null && response.data.balance !== undefined) {
                latestBalance.value = response.data.balance;
                return true;
            }
        } catch (error) {
            console.error('Error fetching balance:', error);
        }
        return false;
    }

    function startBalancePolling() {
        if (pollInterval) {
            clearInterval(pollInterval);
        }

        let attempts = 0;
        pollInterval = setInterval(async () => {
            attempts++;
            const found = await getLatestBalance();
            if (found || attempts >= 5) {
                clearInterval(pollInterval);
                pollInterval = null;
                if (!found) {
                    latestBalance.value = 'Balance not available';
                }
            }
        }, 5000);
    }

    async function fetchLatestBalance() {
        try {
            await axios.post('/balance');
            latestBalance.value = 'Fetching balance...';
            startBalancePolling();
        } catch (error) {
            console.error('Error initiating balance check:', error);
            latestBalance.value = 'Error fetching balance';
        }
    }

    onMounted(() => {
        fetchLatestBalance();
    });

    defineProps({
        transactions: Array,
    });

    const columns = [
        {
            title: 'Name',
            data: 'full_name',
            defaultContent: 'Unknown',
        },
        {
            title: 'MSISDN',
            data: 'msisdn',
            defaultContent: '—',
        },
        {
            title: 'Amount',
            data: 'trans_amount',
        },
        {
            title: 'Balance',
            data: 'org_account_balance',
            defaultContent: '—',
        },
        {
            title: 'Time',
            data: 'trans_time',
            render: {
                display: (data) => (data ? formattedDate(data) : '—'),
                sort: (data) => (data ? new Date(data).getTime() : 0),
            },
        },
    ];

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

    .pagination .active .page-link {
    @apply bg-blue-500 text-white border-blue-500;
    }
</style>
