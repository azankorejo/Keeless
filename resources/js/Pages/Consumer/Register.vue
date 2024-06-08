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
    data: Array
})

const registerForm = useForm({
    email: null,
    username: null,
    errors: Object,
    access_token: props.data.access_token,
    phone: null,
});
const error = ref('');
console.log(props.errors)
const submit = () => {
    registerForm.post(route('consumer.register-post', {subdomain: props.data.domain}));
};
</script>
<template>
    <Head>
        <title>Sign up</title>
        <link rel="icon" type="image/svg+xml" :href="props.data.favicon" />
    </Head>

    <AuthenticationCard>
        <template #logo v-if="!props.data.logo">
            {{ props.data.name }}
        </template>
        <template #logo v-if="props.data.logo">
            <img :src="props.data.logo" width="80px" height="64px" alt="">
        </template>

        <p class="mb-4 text-2xl font-semibold">Sign up</p>

        <p class="text-sm text-red-500 mb-4" v-if="!registerForm.processing">{{error}}</p>

        <form @submit.prevent="submit" class="flex flex-col gap-2">
            <div v-if="props.data.username_needed">
                <InputLabel for="username" value="Username" />
                <TextInput
                    :outline-class="props.data.secondary_color"
                    id="username"
                    v-model="registerForm.username"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="registerForm.errors.username" />
            </div>
            <div v-if="props.data.email_needed">
                <InputLabel for="email" value="Email" />
                <TextInput
                    :outline-class="props.data.secondary_color"
                    id="email"
                    v-model="registerForm.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="email"
                />
                <InputError class="mt-2" :message="registerForm.errors.email" />
            </div>
            <div v-if="props.data.phone_needed">
                <InputLabel for="phone" value="Phone" />
                <TextInput
                    :outline-class="props.data.secondary_color"
                    id="phone"
                    v-model="registerForm.phone"
                    type="number"
                    class="mt-1 block w-full"
                    required
                />
                <InputError class="mt-2" :message="registerForm.errors.phone" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link href="login" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                    Already registered?
                </Link>
                <PrimaryButton :btn-class="props.data.primary_color" class="ms-4" :class="{ 'opacity-25': registerForm.processing }" :disabled="registerForm.processing">
                    Sign up
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
