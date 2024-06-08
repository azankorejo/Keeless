<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';


const props = defineProps({
    data: Array
});

</script>
<template>
    <Head>
        <title>Email Sent</title>
        <link rel="icon" type="image/svg+xml" :href="props.data.favicon" />
    </Head>

    <AuthenticationCard>
        <template #logo v-if="!props.data.logo">
            {{ props.data.name }}
        </template>
        <template #logo v-if="props.data.logo">
            <img :src="props.data.logo" width="80px" height="64px" alt="">
        </template>

        <p class="mb-4 text-2xl font-semibold">Sent.</p>

        <p class="text-sm mb-4">An email containing a magic link for verification has been sent to your registered email address. Please check your inbox (and spam/junk folder) and click on the magic link to complete the verification process. If you haven't received the email within a few minutes, please contact our support team for assistance.</p>
    </AuthenticationCard>
</template>
