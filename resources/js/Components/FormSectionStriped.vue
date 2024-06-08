<script setup>
import {computed, useSlots} from 'vue';
import SectionTitle from './SectionTitle.vue';

defineEmits(['submitted']);

const hasActions = computed(() => !!useSlots().actions);
</script>

<template>
    <div class="mt-5 md:mt-0 col-md-12">
        <form @submit.prevent="$emit('submitted')">
            <div
                class="px-4 py-5 bg-white sm:p-6"
                :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'"
            >
                <div class="grid grid-cols-6 gap-6">
                    <slot name="form"/>
                </div>

                <div v-if="hasActions" class="py-3">
                    <slot name="actions"/>
                </div>
            </div>
        </form>
    </div>
</template>
