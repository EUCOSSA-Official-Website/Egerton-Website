<script setup>
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import DataTable from 'datatables.net-vue3';
    import DataTablesLib from 'datatables.net';
    import 'datatables.net-dt'; // Optional styling for DataTables
    import { onMounted } from 'vue';

    DataTable.use(DataTablesLib);

    defineProps({
        events: Array, // Ensure events are passed as an array
    });

    const columns = [
        {
            title: "#", // Number column title
            data: null, // We don't bind it to any data, this will be handled by render
            render: (data, type, row, meta) => meta.row + 1, // Row numbering (starts from 1)
        },
        { title: "ID", data: "id" },
        { title: "User ID", data: "user_id" },
        { title: "Event ID", data: "event_id" },
        { title: "Receipt Number", data: "receipt_number" },
        { title: "Amount Paid", data: "amount_paid" },
        { 
            title: "Paid At",
            data: "updated_at",
            render: (data) => formatDate(data), // Format date
        },
    ];

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const month = months[date.getMonth()]; // Get the 3-letter month abbreviation        
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    };

    onMounted(() => {
        const dataTableLength = document.querySelector('.dataTables_length');
        const dataTableFilter = document.querySelector('.dataTables_filter');
        
        // Create a wrapper div for entries per page and search box
        const wrapperDiv = document.createElement('div');
        wrapperDiv.classList.add('flex', 'justify-between', 'items-center', 'w-full', 'mb-4');
    
        // Append entries per page and search box to wrapper
        wrapperDiv.appendChild(dataTableFilter); // Search box first
        wrapperDiv.appendChild(dataTableLength); // Entries per page next
    
        const dataTableControlsContainer = document.querySelector('.dataTables_wrapper');
        dataTableControlsContainer.insertBefore(wrapperDiv, dataTableControlsContainer.firstChild);
    });
</script>

<template>
    <Dashboard>
        <div>
            <DataTable
                :data="events"
                :columns="columns"
                :options="{
                    paging: true,
                    searching: true,
                    ordering: true,
                    pageLength: 10, // Set default page length (entries per page)
                    lengthChange: true, // Allow changing entries per page
                    dom: 'lfrtip', // Customize the DOM layout
                }"
                class="table-auto border-collapse border border-gray-300 w-full text-left"
            />
        </div>
    </Dashboard>
</template>
