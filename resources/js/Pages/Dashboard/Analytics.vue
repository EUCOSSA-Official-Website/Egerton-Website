<script setup>
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import { ref, onMounted } from 'vue';
    import { router, usePage } from '@inertiajs/vue3';
    import DataTable from 'datatables.net-vue3';
    import DataTablesCore from 'datatables.net-bs5';
    import 'datatables.net-bs5/css/dataTables.bootstrap5.css'; // ✅ Theming
    import UserAnalytics from '@/Components/Charts/UserAnalytics.vue';


    DataTable.use(DataTablesCore);

    const props = defineProps({
        feedback: Array,
        users: Array
    });

    const page = usePage();
    const user = page.props.auth.user;

    // Dropdown visibility state
    const showDropdown = ref(false);

    const showFeedback = ref(false);
    const showUsers = ref(false);


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
        { 
            title: "Reg", 
            data: "reg_number",
            render: function(data, type, row) {
                return data ? data : 'unavailed';
            }
        },
        { 
            title: "Registration Status", 
            data: "registered", 
            render: (data) => formatDate(data) 
        },
        {title: "Role", data: "role" },
    ];

    // ✅ Conditionally add the Role Change column
    if (user?.is_super_admin) {
        columns2.push({
            title: "Role Change",
            data: null,
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
                return `
                    <div class="relative inline-block text-left">
                        <button class="action-btn flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition-all"
                            data-id="${row.id}">
                            <i class="fas fa-cog"></i> Action
                        </button>

                        <ul class="action-dropdown hidden absolute right-0 bg-white border rounded-lg p-2 shadow-lg text-sm z-50 w-48 inline-block">
                            <li>
                                <a href="#" class="block px-3 py-2 hover:bg-gray-100 rounded transition change-role"
                                    data-id="${row.id}" data-role="${row.role === 'admin' ? 'user' : 'admin'}">
                                    Make ${row.role === 'admin' ? 'User' : 'Admin'}
                                </a>
                            </li>
                            <li>
                                <a href="#" class="block px-3 py-2 hover:bg-gray-100 rounded transition change-super"
                                    data-id="${row.id}" data-status="${row.is_super_admin ? 'false' : 'true'}">
                                    Set Super Admin: ${!row.is_super_admin}
                                </a>
                            </li>
                        </ul>
                    </div>
                `;
            }
        });
    }


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
        ordering: true,
        pageLength: 10,
        lengthChange: true,
        dom: "lfrtip",
        headerCallback: function (thead) {
            thead.querySelectorAll('th').forEach(th => {
                th.classList.add('cursor-pointer');
            });
        },
        order: [] // Disables default sorting
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

    onMounted(() => {
        document.addEventListener('click', function (event) {
            const target = event.target.closest('.action-btn');

            // Handle toggle
            if (target) {
                event.preventDefault();

                const userId = target.dataset.id;

                // Close all others first
                document.querySelectorAll('.action-dropdown').forEach(dropdown => {
                    if (!dropdown.classList.contains('hidden')) dropdown.classList.add('hidden');
                });

                // Toggle the clicked one
                const dropdown = target.parentElement.querySelector('.action-dropdown');
                if (dropdown) {
                    dropdown.classList.toggle('hidden');
                }

                return;
            }

            // Handle role change
            if (event.target.classList.contains('change-role')) {
                event.preventDefault();
                const userId = event.target.dataset.id;
                const newRole = event.target.dataset.role;

                router.put(route('users.role.update', userId), { role: newRole }, {
                    preserveScroll: true,
                    onSuccess: () => console.log(`User ${userId} role updated to ${newRole}`)
                });

                return;
            }

            // Handle super admin toggle
            if (event.target.classList.contains('change-super')) {
                event.preventDefault();
                const userId = event.target.dataset.id;
                const newStatus = event.target.dataset.status === 'true';

                router.put(route('users.super.update', userId), { is_super_admin: newStatus }, {
                    preserveScroll: true,
                    onSuccess: () => console.log(`User ${userId} super admin set to ${newStatus}`)
                });

                return;
            }

            // If clicked outside, close all dropdowns
            if (!event.target.closest('.relative')) {
                document.querySelectorAll('.action-dropdown').forEach(el => el.classList.add('hidden'));
            }
        });
    });


</script>

<template>
    <Dashboard>
        <!-- Feedback Section -->
        <div class="mb-6 border border-gray-300 rounded">
            <!-- Header -->
            <button
                @click="showFeedback = !showFeedback"
                class="w-full bg-blue-500 text-white text-left px-6 py-4 text-2xl tracking-wide font-bold hover:bg-blue-600 transition duration-200 rounded-t flex items-center gap-3"
            >
                <i :class="showFeedback ? 'fas fa-chevron-down' : 'fas fa-chevron-right'"></i>
                <span>User Feedback</span>
            </button>

            <!-- Content -->
            <div v-show="showFeedback" class="p-4">
                <DataTable
                    :data="feedback"
                    :columns="columns"
                    :options="tableOptions"
                    class="table-auto border-collapse border border-gray-300 w-full text-left"
                />
            </div>
        </div>

        <!-- Users Section -->
        <div class="mb-6 border border-gray-300 rounded">
            <!-- Header -->
            <button
                @click="showUsers = !showUsers"
                class="w-full bg-blue-500 text-white text-left px-6 py-4 text-2xl tracking-wide font-bold hover:bg-blue-600 transition duration-200 rounded-t flex items-center gap-3"
            >
                <i :class="showUsers ? 'fas fa-chevron-down' : 'fas fa-chevron-right'"></i>
                <span>Site Users</span>
            </button>


            <!-- Content -->
            <div v-show="showUsers" class="p-4">
                <!-- Export Button -->
                <div class="relative inline-block text-left mb-4 z-30">
                    <button @click="showDropdown = !showDropdown"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700 flex items-center">
                        <i class="fas fa-download mr-1"></i> Export
                        <i :class="showDropdown ? 'fa-chevron-up' : 'fa-chevron-down'" class="fas ml-2"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div v-if="showDropdown" class="absolute left-0 mt-2 w-32 bg-white border rounded shadow-md z-50">
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
        </div>

        <!-- Graph Analytics -->
        <UserAnalytics :users="users" />


    </Dashboard>
</template>


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
