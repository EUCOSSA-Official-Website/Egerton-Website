<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, usePage } from '@inertiajs/vue3';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { computed, ref, nextTick } from 'vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import { router } from '@inertiajs/vue3';
    import Modal from '@/Components/Modal.vue';
    import { useForm } from '@inertiajs/vue3';
    import DangerButton from '@/Components/DangerButton.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputError from '@/Components/InputError.vue';

    // Access the page props using usePage
    const page = usePage();
    
    // Compute the user from the auth prop
    const user = computed(() => page.props.auth.user);

    // Getting the Events
    const props = defineProps({
        'event': Object
    })

    // Computed Property to check if the event has passed
    const isEventPassed = computed(() => {
        const currentDate = new Date();
        const eventEndTime = new Date(props.event.event_day); // Assuming end_time is in a valid date format
       // Extract hours and minutes from the end_time string
        const [hours, minutes] = props.event.end_time.split(':').map(Number);
        
        // Set the hours and minutes for the event end time
        eventEndTime.setHours(hours, minutes, 0, 0); // Set event end time to HH:MM:00.000

        return currentDate > eventEndTime;
    });

    const formattedDate = computed(() => {
      const date = new Date(props.event.event_day);
      return `${date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })} at ${date.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
      })}`;
    });
    const formattedCreatedDate = computed(() => {
      const date = new Date(props.event.created_at);
      return `${date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })} at ${date.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
      })}`;
    });

    // Set up router and define the goBack function
    const goBack = () => {
        window.history.back(); // Uses browser's history API to navigate back
    };

    // Sending a notification to frontend for copied to clipboard
    // Notification state
    const notification = ref(false);

    // Method to copy the current page URL to the clipboard and show notification
    function copyLinkToClipboard() {
        navigator.clipboard.writeText(window.location.href)
            .then(() => {
                // Display an alert to notify the user
                alert("Event Link copied to Clipboard!");

                notification.value = true;
                setTimeout(() => {
                    notification.value = false;
                }, 2000);
            })
            .catch(err => {
                console.error("Failed to copy: ", err);
            });
    }

    // Method to confirm and handle deletion
    function confirmDelete() {
    if (confirm('Are you sure you want to delete this event?')) {
        // If confirmed, send the DELETE request via Inertia
        router.delete(route('events.destroy', { event: props.event.id }));
    }
    }

    // Showing The Event Application Form
    const showForm = ref(false);
    const getingTicketModal = ref(false);

    const phoneInput = ref(null);
    const phoneNumber = ref(user.value?.mobile || '');
    const preferedName = ref(user.value?.name);
    const email = ref(user.value?.email)

    const form = useForm({
        event: props.event.id,
        phoneNumber: phoneNumber,
        preferedName: preferedName,
        email: email,
    });

    const getTicketModal = () => {
        getingTicketModal.value = true;

        nextTick(() => phoneInput.value.focus());
    };

    const submitPayment = () => {
        form.post(route('event-payment', { event: props.event.id }), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => phoneInput.value.focus(),
            onFinish: () => form.reset(),
        });
    };

    const closeModal = () => {
        getingTicketModal.value = false;

        form.clearErrors();
        form.reset();
    };

    // Function to redirect to login page using Inertia and the route helper

    const redirectToLogin = () => {
        const loginUrl = route('login'); // Use route helper to generate the login URL
        console.log('Redirecting to login URL:', loginUrl); // Log the URL to see if it's correct
        router.visit(loginUrl);
    };

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Event" />

        <header class="bg-blue-700 text-center text-white py-5 relative">
            <h1 class="text-3xl px-10">{{ props.event.title }}</h1>
            
            <button @click="goBack">
                <svg width="50px" height="50px" viewBox="0 -0.5 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="absolute left-2 lg:left-5 top-4 si-glyph si-glyph-button-arrow-left" fill="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>1188</title> <defs> </defs> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g transform="translate(1.000000, 0.000000)" fill="#ffffff"> <path d="M0,8.041 C0,3.652 3.582,0.082 7.985,0.082 C12.386,0.082 15.968,3.652 15.968,8.041 C15.968,12.43 12.386,16 7.985,16 C3.582,16 0,12.43 0,8.041 L0,8.041 Z M14.057,8.041 C14.057,4.708 11.342,1.996 8.006,1.996 C4.669,1.996 1.954,4.708 1.954,8.041 C1.954,11.374 4.67,14.086 8.006,14.086 C11.343,14.086 14.057,11.374 14.057,8.041 L14.057,8.041 Z" class="si-glyph-fill"> </path> <path d="M7.975,5.02 L4.071,8.022 L7.976,10.973 L7.976,8.97 L11.116,8.97 C11.461,8.97 11.907,8.646 11.907,8.015 C11.907,7.385 11.424,7.04 11.081,7.04 L7.976,7.04 L7.976,5.02 L7.975,5.02 Z" class="si-glyph-fill"> </path> </g> </g> </g></svg>
            </button>
        </header>

        <Modal :show="getingTicketModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 ">
                    Get Your Event Ticket Here!
                </h2>

                <p class="mt-1 text-sm text-gray-600 ">
                    Confirm Your Account Details below and payment number then Pay for the 
                    Event. 
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-6 bg-gray-50 rounded-lg shadow-md">
                    <!-- User Name -->
                    <div class="flex items-center space-x-3 text-lg font-medium text-gray-700">
                        <i class="fas fa-user text-indigo-500 text-2xl"></i>
                        <span>Your Name:</span>
                        <span :class="{'text-gray-500 italic': !user?.name}">{{ user?.name || 'unregistered' }}</span>
                    </div>

                    <!-- Event Charges -->
                    <div class="flex items-center space-x-3 text-lg font-medium">
                        <i class="fas fa-coins text-yellow-500 text-2xl"></i>
                        <span>Event Charges:</span>
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg font-bold text-4xl">
                            ksh: {{ props.event.event_charge }}
                        </span>
                    </div>

                    <!-- Event Name -->
                    <div class="flex items-center space-x-3 text-lg font-medium text-gray-700">
                        <i class="fas fa-calendar-alt text-green-500 text-2xl"></i>
                        <span>Event Name:</span>
                        <span class="text-green-700 font-semibold text-2xl">
                            {{ props.event.title }}
                        </span>
                    </div>
                </div>


                <div class="flex row justify-between w-3/4">
                    <div class="mt-6">
                        <InputLabel for="preferedName" value="Pefered Name" />

                        <TextInput
                            id="preferedName"
                            v-model="form.preferedName"
                            type="text"
                            class="mt-1 block"
                            placeholder="Prefered Name"
                        />

                        <InputError :message="form.errors.preferedName" class="mt-2" />
                    </div>
                    <div class="mt-6">
                        <InputLabel for="email" value="Pefered Email" />
                        
                        <TextInput
                        id="email"
                        v-model="form.email"
                        type="text"
                        class="mt-1 block"
                        placeholder="email"
                        />
                        
                        <span class="text text-xs text-red-500">The email where ticket is sent to! </span>
                        <InputError :message="form.errors.email" class="mt-2" />
                    </div>
                </div>

                <div class="mt-6">
                    <InputLabel for="phoneNumber" value="Mpesa Phone Number" />

                    <TextInput
                        id="phoneNumber"
                        v-model="form.phoneNumber"
                        type="text"
                        class="mt-1 block w-3/4"
                        placeholder="Phone Number"
                        ref="phoneInput"
                    />

                    <InputError :message="form.errors.phoneNumber" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <PrimaryButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="submitPayment"
                    >
                        Get Ticket
                    </PrimaryButton>
                </div>
            </div>
        </Modal>

        <div class="grid grid-cols-12 min-h-[70vh]">
            <div class="col-span-12 lg:col-span-8 p-6 text-gray-800 bg-white my-3">
                <ul class="space-y-5">
                    <li><strong>Description: </strong> {{ props.event.description }}</li>
                    <li><strong>Start Time: </strong> {{ props.event.start_time }}</li>
                    <li><strong>End Time: </strong> {{ props.event.end_time }}</li>
                    <li><strong>Event Day: </strong> {{ formattedDate }}</li>
                    <li><strong>Speaker: </strong> {{ props.event.speaker }}</li>
                    <li><strong>Created Day: </strong> {{ formattedCreatedDate }}</li>
                </ul>
            </div>

            <div class="col-span-12 lg:col-span-4 lg:col-start-9 p-6 my-3 bg-blue-400 relative">
                <img :src="props.event.image" alt="">
                <!-- Badge for past events -->
                <span v-if="isEventPassed" class="bg-red-500 text-white text-xl font-bold px-3 py-2 rounded absolute right-3 top-3">
                    Event Passed
                </span>
                
                <!-- Badge Hackathons -->
                <span v-if="props.event.category === 'hackathon'" class="bg-blue-500 text-white text-xl font-bold px-3 py-2 rounded absolute left-3 top-3">
                    Hackathon
                </span>

                <div v-if="user?.role === 'admin'" class="flex justify-between sm:text-xl mt-5 items-center">
                    <!-- <Link v-if="props.event.event_charge" 
                        class="text-3xl" :href="route('event-payment', {event: props.event.id})" 
                        as="button" method="post" @click="getTicketModal">
                        <PrimaryButton>Get Ticket</PrimaryButton>
                    </Link> -->
                    
                    <PrimaryButton 
                        v-if="props.event.event_charge" 
                        class="text-3xl" 
                        @click="getTicketModal()"
                    >
                        Get Ticket
                    </PrimaryButton>
                    
                    <Link href="#" ><PrimaryButton  @click="copyLinkToClipboard" class="bg-white hover:bg-slate-200 text-gray-900" as="button">Share Event</PrimaryButton></Link>
                    <button @click="confirmDelete" class="bg-red-600 hover:bg-red-700">
                        <PrimaryButton class="bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-900">Delete Event</PrimaryButton>
                    </button>

                    <SecondaryButton> <Link :href="route('events.edit', {event: props.event.id})"> Edit Event </Link></SecondaryButton>

                </div>
                <div v-else class="flex justify-between mt-5">
                    <!-- <Link v-if="props.event.event_charge" class="text-3xl" :href="route('event-payment', {event: props.event.id})" as="button" method="post"><PrimaryButton>Get Ticket</PrimaryButton></Link> -->
                    <PrimaryButton 
                        v-if="props.event.event_charge" 
                        class="text-3xl" 
                        @click="user ? (console.log('User authenticated, opening ticket modal') , getTicketModal()) :redirectToLogin()"
                    >
                        Get Ticket
                    </PrimaryButton>                    

                    <SecondaryButton  @click="copyLinkToClipboard" class="text-3xl">Share Event</SecondaryButton>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
