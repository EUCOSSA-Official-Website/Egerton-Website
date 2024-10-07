<template>
    <div class="card bg-white shadow-md rounded-lg p-6 relative">
      <img :src="event.image" alt="Event Image" class="w-full h-48 object-cover rounded-t-md mb-4" />
  
      <h2 class="text-xl font-semibold mb-2 max-h-[56px] overflow-y-auto">{{ truncatedTitle }}</h2>
  
        <p class="text-sm text-gray-600 mb-4">
            {{ truncatedDescription }}
        </p>
  
        <div class="text-sm text-gray-500">
            <p><strong>Event Day:</strong> {{ event.event_day }}</p>
            <p><strong>Time:</strong> {{ event.start_time }} - {{ event.end_time }}</p>
            <p><strong>Speaker:</strong> {{ event.speaker }}</p>
        </div>

        <!-- Badge for past events -->
        <span v-if="isEventPassed" class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded absolute right-3 top-3">
            Event Passed
        </span>
    </div>
  </template>

<script setup>
    import { computed } from 'vue';

    const props = defineProps({
        event: Object, 
    });

    // Computed property to truncate the description
    const maxLength = 85;
    const truncatedDescription = computed(() => {
      return props.event.description.length > maxLength
        ? props.event.description.substring(0, maxLength) + '...'
        : props.event.description;
    });

    // Computed Property to truncate the Title:

    const maxLenghth = 35;
    const truncatedTitle = computed(() => {
        return props.event.title.length > maxLenghth 
        ? props.event.title.substring(0, maxLenghth) + '...'
        : props.event.title
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

</script>
  
  <style scoped>
    .card {
        border-radius: 0.5rem;
        background-color: #ffffff;
    }
  </style>
  