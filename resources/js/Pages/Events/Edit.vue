<template>
    <Dashboard>

        <div class="max-w-lg mx-auto p-4 bg-white shadow-md rounded sm:my-5">
            <h2 class="text-2xl font-bold mb-4">Update Event</h2>

            <div class="mb-4">
                <label for="category" class="form-label text-black">
                    Event Type <span class="text-red-500">*</span>
                </label>
                <div class="mt-2 space-y-2 space-x-5">
                    <div class="inline">
                        <input type="radio" id="techfriday" value="eucossa_tech_friday" v-model="form.category" name="category" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="techfriday" class="ml-2 text-sm text-black">Tech Friday Event</label>
                    </div>
                    <div class="inline">
                        <input type="radio" id="hackathon" value="hackathon" v-model="form.category" name="category" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="hackathon" class="ml-2 text-sm text-black">Hackathon</label>
                    </div>
                </div>
            </div>

            <form @submit.prevent="submitForm">
            <!-- Event Title -->
            <div class="mb-4">
                <label for="title" class="block font-medium text-black">Event Title</label>
                <input type="text" id="title" v-model="form.title" class="form-input" placeholder="Enter event title" />
                <div v-if="form.errors.title" class="input-error"> {{ form.errors.title }} </div>
            </div>

            <!-- Event Description -->
            <div class="mb-4">
                <label for="description" class="block font-medium text-black">Description</label>
                <textarea id="description" v-model="form.description"
                class="form-input"
                placeholder="Enter event description"
                required
                ></textarea>
                <div v-if="form.errors.description" class="input-error"> {{ form.errors.description }} </div>
            </div>

            <!-- Event Day (Calendar) -->
            <div class="mb-4">
                <label for="event_day" class="block font-medium text-black">Event Day</label>
                <input type="date" id="event_day" v-model="form.event_day" class="form-input"required/>
                <div v-if="form.errors.event_day" class="input-error"> {{ form.errors.event_day }} </div>
            </div>

            <div class="grid grid-cols-2 space-x-4">
                <!-- Start Time -->
                <div class="mb-4 col-span-1">
                    <label for="start-time" class="block font-medium text-black">Start Time</label>
                    <input type="time" id="start-time"
                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2"
                    min="06:00"
                    max="19:00"
                    v-model="form.start_time"
                    required
                    />
                </div>
    
                <!-- End Time -->
                <div class="mb-4 col-span-1">
                    <label for="end-time" class="block font-medium text-black">End Time</label>
                    <input type="time" id="end-time"
                    class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2"
                    min="06:00"
                    max="19:00"
                    v-model="form.end_time"
                    required
                    />
                </div>
            </div>

            <!-- Speaker -->
            <div class="mb-4">
                <label for="speaker" class="block font-medium text-black">Speaker</label>
                <input type="text" id="speaker" v-model="form.speaker" class="form-input" placeholder="Enter speaker's name" required />
                <div v-if="form.errors.speaker" class="input-error"> {{ form.errors.speaker }} </div>
            </div>

            <!-- Reminder Checkbox -->
            <div class="mb-4">
                <label class="block font-medium text-black">
                <input
                    type="checkbox"
                    v-model="eventPaid"
                    class="mr-2 leading-tight"
                />
                Paid Event?
                </label>
                <div v-if="eventPaid" class="mt-5">
                    <input type="number" id="amount" v-model="form.event_charge" class="form-input" placeholder="Enter Event Charges" />
                </div>
                <div v-if="form.errors.event_charge" class="input-error"> {{ form.errors.event_charge }} </div>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-700 focus:outline-none"
            >
                Update Event
            </button>
            </form>
        </div>
    </Dashboard>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import { ref } from 'vue';

    // Getting the Events
    const props = defineProps({
        'event': Object
    })

    const eventPaid = ref(true);
    

    // Initializing the form using `useForm`
    const form = useForm({
        category: props.event.category,
        title: props.event.title,
        description: props.event.description,
        event_day: props.event.event_day,
        start_time: props.event.start_time, // Default start time
        end_time: props.event.end_time,   // Default end time
        speaker: props.event.speaker,
        event_charge: props.event.event_charge,
    });

    // Method to handle image upload
    // const handleImageUpload = (event) => {
    //     form.image = event.target.files[0]; // Store the uploaded image file in the form object
    // };

    const submitForm = () => {    
        console.log(form.category.value);
        form.put(route('events.update', {event: props.event.id}));        
    };

</script>
