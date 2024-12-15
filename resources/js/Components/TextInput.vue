<script setup>
    import { onMounted, ref } from 'vue';

    const model = defineModel({
        type: String,
        default: Text,
        required: true,
    });

    const input = ref(null);

    onMounted(() => {
        if (input.value.hasAttribute('autofocus')) {
            input.value.focus();
        }
    });

    defineExpose({ focus: () => input.value.focus() });

    // Define a prop to control whether the toggle should be visible
    const props = defineProps({
        showToggle: {
            type: Boolean,
            default: false,  // By default, the toggle will not be visible
        },
        type: {
            type: String,
            default: 'text', // Default input type
        },
    });

    const showPassword = ref(false); // Control password visibility through the toggle props

    // Toggle the password visibility
    const togglePasswordVisibility = () => {
        showPassword.value = !showPassword.value;
    };
</script>

<template>

    <div class="relative px-0 border-none">
        <input
            class="w-full block border-gray-300    focus:border-indigo-500  focus:ring-indigo-500  rounded-md shadow-sm"
            v-model="model"
            ref="input"
            :type="showToggle && props.type === 'password' ? (showPassword ? 'text' : 'password') : props.type"
        />

        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-500" 
            v-if="showToggle"  
            @click="togglePasswordVisibility"
        >
            <span v-if="showPassword">Hide</span>
            <span v-else>Show</span>
        </button>

    </div>
</template>
