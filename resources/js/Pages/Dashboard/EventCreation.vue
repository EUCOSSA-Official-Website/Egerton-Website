<template>
    <Dashboard>

        <div class="max-w-lg mx-auto p-4 bg-white shadow-md rounded sm:my-5">
            <h2 class="text-2xl font-bold mb-4">Create Event</h2>

            <form @submit.prevent="submitForm">
            <!-- Event Title -->
            <div class="mb-4">
                <label for="title" class="block font-medium text-gray-700">Event Title</label>
                <input type="text" id="title" v-model="form.title" class="form-input" placeholder="Enter event title" />
                <div v-if="form.errors.title" class="input-error"> {{ form.errors.title }} </div>
            </div>

            <!-- Event Description -->
            <div class="mb-4">
                <label for="description" class="block font-medium text-gray-700">Description</label>
                <textarea id="description" v-model="form.description"
                class="form-input"
                placeholder="Enter event description"
                required
                ></textarea>
                <div v-if="form.errors.description" class="input-error"> {{ form.errors.description }} </div>
            </div>

            <!-- Event Image -->
            <div class="mb-4">
                <label for="image" class="block font-medium text-gray-700">Upload Image</label>
                <input type="file" id="image" @change="handleImageUpload"
                    class="form-input"
                    required
                />
                <div v-if="form.errors.image" class="input-error"> {{ form.errors.image }} </div>
            </div>

            <!-- Event Day (Calendar) -->
            <div class="mb-4">
                <label for="event_day" class="block font-medium text-gray-700">Event Day</label>
                <input type="date" id="event_day" v-model="form.event_day" class="form-input"required/>
                <div v-if="form.errors.event_day" class="input-error"> {{ form.errors.event_day }} </div>
            </div>

            <!-- Start Time -->
            <div class="mb-4">
                <label for="start-time" class="block font-medium text-gray-700">Start Time</label>
                <input type="time" id="start-time"
                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2"
                min="09:00"
                max="19:00"
                v-model="form.start_time"
                required
                />
            </div>

            <!-- End Time -->
            <div class="mb-4">
                <label for="end-time" class="block font-medium text-gray-700">End Time</label>
                <input type="time" id="end-time"
                class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2"
                min="09:00"
                max="19:00"
                v-model="form.end_time"
                required
                />
            </div>

            <!-- Speaker -->
            <div class="mb-4">
                <label for="speaker" class="block font-medium text-gray-700">Speaker</label>
                <input type="text" id="speaker" v-model="form.speaker" class="form-input" placeholder="Enter speaker's name" required />
                <div v-if="form.errors.speaker" class="input-error"> {{ form.errors.speaker }} </div>
            </div>

            <!-- Reminder Checkbox -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">
                <input
                    type="checkbox"
                    v-model="eventPaid"
                    class="mr-2 leading-tight"
                />
                Paid Event?
                </label>
                <div v-if="eventPaid" class="mt-5">
                    <input type="number" id="amount" v-model="form.event_charge" class="form-input" placeholder="Enter Event Charges" required />
                </div>
                <div v-if="form.errors.speaker" class="input-error"> {{ form.errors.speaker }} </div>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md shadow hover:bg-indigo-700 focus:outline-none"
            >
                Create Event
            </button>
            </form>
        </div>
    </Dashboard>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import Dashboard from '@/Pages/Dashboard/Dashboard.vue';
    import { ref } from 'vue';

    const eventPaid = ref(false);
    

    // Initializing the form using `useForm`
    const form = useForm({
        title: '',
        description: '',
        image: null, // Placeholder for image file
        event_day: '',
        start_time: '14:00', // Default start time
        end_time: '16:00',   // Default end time
        speaker: '',
        event_charge: '',
    });

    // Method to handle image upload
    const handleImageUpload = (event) => {
        form.image = event.target.files[0]; // Store the uploaded image file in the form object
    };

    const submitForm = () => {      
      form.post(route('events.store'));
    };

</script>
