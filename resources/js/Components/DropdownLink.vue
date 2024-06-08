<script setup>
import { Link } from '@inertiajs/vue3';
import { defineProps, defineEmits } from 'vue';

const emit = defineEmits(['click']);
const handleClick = () => {
    emit('click');
}
defineProps({
    href: String,
    as: String,
});

</script>

<template>
    <div>
        <button v-if="as == 'button'" type="submit" @click="handleClick" class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
            <slot />
        </button>

        <a v-else-if="as =='a'" :href="href" @click="handleClick" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
            <slot />
        </a>

        <Link v-else :href="href" @click="handleClick" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
            <slot />
        </Link>
    </div>
</template>
