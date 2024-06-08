<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {ref} from 'vue'

const props = defineProps({
    error: String,
    data: Array
})
</script>
<template>
    <Head>
        <title>Authentication failed</title>
        <link rel="icon" type="image/svg+xml" :href="props.data.favicon" />
    </Head>

    <AuthenticationCard>
        <template #logo v-if="!props.data.logo">
            {{ props.data.name }}
        </template>
        <template #logo v-if="props.data.logo">
            <img :src="props.data.logo" width="80px" height="64px" alt="">
        </template>

        <p class="mb-4 text-2xl font-semibold">Failed.</p>

        <p class="text-sm mb-4">{{props.error}}</p>
    </AuthenticationCard>
</template>
