<script setup>
    import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    BarElement,
    CategoryScale,
    LinearScale,
    PointElement,
    } from 'chart.js';
    import { Line, Bar } from 'vue-chartjs';

    ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    BarElement,
    CategoryScale,
    LinearScale,
    PointElement
    );

    const props = defineProps({
    users: Array
    });

    // Step 1: Group created_at by day
    const dateCounts = {};
    props.users.forEach(user => {
    const date = new Date(user.created_at).toISOString().split('T')[0];
    if (date) {
        dateCounts[date] = (dateCounts[date] || 0) + 1;
    }
    });

    // Step 2: Sort and build cumulative data
    const sortedDates = Object.keys(dateCounts).sort();
    let cumulative = 0;
    const cumulativeCounts = sortedDates.map(date => {
    cumulative += dateCounts[date];
    return cumulative;
    });

    // Line chart config (cumulative)
    const lineChartData = {
    labels: sortedDates,
    datasets: [{
        label: 'Cumulative Registrations',
        backgroundColor: '#3B82F6',
        borderColor: '#3B82F6',
        data: cumulativeCounts,
        fill: false,
        tension: 0.4,
        pointRadius: 2
    }]
    };

    const lineChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: true },
        title: {
        display: true,
        text: 'Cumulative User Registrations',
        font: { weight: 'bold' }
        }
    },
    scales: {
        x: {
        title: {
            display: true,
            text: 'Date',
            font: { weight: 'bold' }
        },
        ticks: {
            maxRotation: 45,
            minRotation: 45,
            font: { weight: 'bold' }
        },
        type: 'category'
        },
        y: {
        beginAtZero: true,
        title: {
            display: true,
            text: 'Total Users',
            font: { weight: 'bold' }
        },
        ticks: {
            font: { weight: 'bold' }
        }
        }
    }
    };


    // Registered vs. Unregistered
    const registeredCount = props.users.filter(u => u.registered !== null).length;
    const unregisteredCount = props.users.length - registeredCount;

    const barChartData = {
    labels: ['Registered', 'Unregistered'],
    datasets: [{
        label: 'User Count',
        backgroundColor: ['#10B981', '#EF4444'],
        data: [registeredCount, unregisteredCount]
    }]
    };

    const barChartOptions = {
    responsive: true,
    plugins: {
        legend: { display: false },
        title: { display: true, text: 'Registration Status Distribution' }
    }
    };
</script>

<template>
  <div class="grid grid-cols-1 gap-6 mb-10 mx-auto">
    <!-- Scrollable Line Chart Wrapper -->
    <div class="bg-white p-4 rounded shadow overflow-x-auto lg:mx-3">
      <div class="min-w-[600px] h-[400px]">
        <Line :data="lineChartData" :options="lineChartOptions" />
      </div>
    </div>

    <!-- Bar Chart -->
    <div class="bg-white p-4 rounded shadow  lg:w-[60%] mx-auto">
      <Bar class="lg:w-[70%] mx-auto" :data="barChartData" :options="barChartOptions" />
    </div>
  </div>
</template>
