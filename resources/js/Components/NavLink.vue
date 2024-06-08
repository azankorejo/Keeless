<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex items-center text-xl bg-black text-white p-5 rounded-full leading-5 text-gray-900 focus:outline-none  transition duration-150 ease-in-out'
        : 'inline-flex items-center text-xl p-5 border-b-2 border-transparent font-medium leading-5 hover:text-gray-700  transition duration-150 ease-in-out';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
