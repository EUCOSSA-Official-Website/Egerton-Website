<template>
    <Dashboard>
        <div>
            <h1 class="mx-auto text-2xl text-center font-bold">Balances</h1>
            <Link  @click="fetchLatestBalance" :href="route('balance')" method='post' as='button' class="block bg-blue-700 text-white rounded-sm px-3 py-1 my-4">Check Latest Balance</Link>
            <table class="min-w-full bg-white border border-gray-800">
                <thead class="bg-gray-100 sticky top-0 z-10">
                    <tr class="bg-gray-100 text-left text-gray-600 font-semibold">
                        <th class="py-1 px-2 border-b border-slate-800">Chanel</th>
                        <th class="py-1 px-2 border-b border-slate-800">Time</th>
                        <th class="py-1 px-2 border-b border-slate-800">Balance</th>
                    </tr>
                </thead>
                <tbody class="max-h-[20vh]">
                    <tr v-for="(balance, index) in balances" :key="index" class="hover:bg-gray-50"
                        :class="index % 2 === 0 ? 'bg-gray-100' : 'bg-white'">
                        <td class="py-3 px-1 border border-slate-800">{{ balance.gateway }}</td>
                        <td class="py-3 px-1 border border-slate-800">{{ formattedDate(balance.retrieved_at) }}</td>
                        <td class="py-3 px-1 border border-slate-800">{{ balance.balance }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Dashboard>
</template>

<script setup>
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import { Link } from '@inertiajs/vue3';
    import { router } from '@inertiajs/vue3';

    function fetchLatestBalance() {
        setTimeout(() => {
            router.visit(route('dashboard.finances'), { method: 'get', preserveState: true });
        }, 4000);
    }

    // Receiving The Balances Object
    defineProps({
        'balances': Array
    })

    // Formatted Date
    const formattedDate = (transactionDate) => {
      const date = new Date(transactionDate);
      return `${date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })} at ${date.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
      })}`;
    };

</script>
