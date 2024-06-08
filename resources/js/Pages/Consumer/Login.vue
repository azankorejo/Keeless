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

const form = useForm({
    email: null,
    username: null,
    phone: null,
});

const error = ref('');

const submit = () => {
    form.transform(data => ({
        ...data,
        access_token: props.data.access_token,
    })).post(route('consumer.login-post', {subdomain: props.data.domain}), {
        onError: function (res) {
            error.value = res.error;
        }
    });
};
</script>
<template>
    <Head>
        <title>Log in</title>
        <link rel="icon" type="image/svg+xml" :href="props.data.favicon" />
    </Head>

    <AuthenticationCard>
        <template #logo v-if="!props.data.logo">
            {{ props.data.name }}
        </template>
        <template #logo v-if="props.data.logo">
            <img :src="props.data.logo" width="80px" height="64px" alt="">
        </template>

        <p class="mb-4 text-2xl font-semibold">Login</p>

        <p class="text-sm text-red-500 mb-4" v-if="!form.processing">{{error}}</p>

        <form @submit.prevent="submit" class="flex flex-col gap-2">
            <div v-if="props.data.email_needed">
                <InputLabel for="email" value="Email" />
                <TextInput
                    :outline-class="props.data.secondary_color"
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="email"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div v-if="props.data.username_needed">
                <InputLabel for="username" value="Username" />
                <TextInput
                    :outline-class="props.data.secondary_color"
                    id="username"
                    v-model="form.username"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.username" />
            </div>
            <div v-if="props.data.phone_needed">
                <InputLabel for="phone" value="Phone" />
                <TextInput
                    :outline-class="props.data.secondary_color"
                    id="phone"
                    v-model="form.phone"
                    type="number"
                    class="mt-1 block w-full"
                    required
                />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link href="register" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                    Create account?
                </Link>
                <PrimaryButton :btn-class="props.data.primary_color" class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
