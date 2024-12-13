<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, usePage } from '@inertiajs/vue3';
    import { computed } from 'vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { ref } from 'vue';
    import SecondaryButton from '@/Components/SecondaryButton.vue';
    import { router } from '@inertiajs/vue3';


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

        <div class="grid grid-cols-12 min-h-[70vh]">
            <div class="col-span-12 lg:col-span-8 p-6 text-gray-800 bg-white my-3">
                <ul class="space-y-5">
                    <li><strong>Description: </strong> {{ props.event.description }}</li>
                    <li><strong>Start Time: </strong> {{ props.event.start_time }}</li>
                    <li><strong>End Time: </strong> {{ props.event.end_time }}</li>
                    <li><strong>Event Day: </strong> {{ props.event.event_day }}</li>
                    <li><strong>Speaker: </strong> {{ props.event.speaker }}</li>
                    <li><strong>Created Day: </strong> {{ formattedDate }}</li>
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
                    <Link v-if="props.event.event_charge" class="text-3xl" :href="route('event-payment', {event: props.event.id})" as="button" method="post"><PrimaryButton>Get Ticket</PrimaryButton></Link>
                    <Link href="#" ><PrimaryButton  @click="copyLinkToClipboard" class="bg-white hover:bg-slate-200 text-gray-900" as="button">Share Event</PrimaryButton></Link>
                    <button @click="confirmDelete" class="bg-red-600 hover:bg-red-700">
                        <PrimaryButton class="bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-900">Delete Event</PrimaryButton>
                    </button>
                </div>
                <div v-else class="flex justify-between mt-5">
                    <Link v-if="props.event.event_charge" class="text-3xl" :href="route('event-payment', {event: props.event.id})" as="button" method="post"><PrimaryButton>Get Ticket</PrimaryButton></Link>
                    <SecondaryButton  @click="copyLinkToClipboard" class="text-3xl">Share Event</SecondaryButton>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
