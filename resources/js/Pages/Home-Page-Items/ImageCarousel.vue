<template>
  <section class="bg-white pt-8 pb-5 mt-5" id="sec-1115">
    <h2 class="text-center font-sans font-semibold text-4xl">Our Members</h2>
    <p class="text-center text-lg py-4 max-w-2xl mx-auto">
      Egerton Computer Science Students Always Strive to Seek Solutions and Spearhead Innovations.
    </p>
    
    <div class="relative max-w-4xl mx-auto overflow-hidden">
      <div class="flex space-x-4 overflow-x-auto scrollbar-hide snap-x snap-mandatory p-4 justify-center items-center">
        <div v-for="(image, index) in images" :key="index" 
             class="flex-shrink-0 snap-center rounded-lg overflow-hidden shadow-lg transition-all duration-500"
             :class="{ 'w-80 h-60 scale-110': index === currentIndex, 'w-64 h-48 opacity-70': index !== currentIndex }">
          <img class="w-full h-full object-cover rounded-lg" :src="image" alt="Member">
        </div>
      </div>

      <!-- Navigation Buttons -->
      <button class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full shadow-md hover:bg-gray-700" @click="prevImage">
        &#10094;
      </button>
      <button class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full shadow-md hover:bg-gray-700" @click="nextImage">
        &#10095;
      </button>

      <!-- Dot Indicators -->
      <div class="flex justify-center mt-6 space-x-2">
        <button v-for="(image, index) in images" :key="'dot-' + index" @click="currentIndex = index"
                class="w-3 h-3 rounded-full"
                :class="{ 'bg-blue-500': index === currentIndex, 'bg-gray-300 hover:bg-gray-500': index !== currentIndex }">
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const images = ref([
  '/assets/SliderImages/photo-1577897113051-1a0395bfc3e2.jpeg',
  '/assets/SliderImages/photo-1577897113051-1a0395bfc3e2.jpeg',
  '/assets/SliderImages/photo-1577897113051-1a0395bfc3e2.jpeg',
  '/assets/SliderImages/photo-1577897113051-1a0395bfc3e2.jpeg',
]);

const currentIndex = ref(0);
let carouselInterval;

const startCarousel = () => {
  carouselInterval = setInterval(() => {
    currentIndex.value = (currentIndex.value + 1) % images.value.length;
  }, 3000);
};

const stopCarousel = () => {
  clearInterval(carouselInterval);
};

const nextImage = () => {
  currentIndex.value = (currentIndex.value + 1) % images.value.length;
};

const prevImage = () => {
  currentIndex.value = (currentIndex.value - 1 + images.value.length) % images.value.length;
};

onMounted(startCarousel);
onBeforeUnmount(stopCarousel);
</script>

<style>
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
