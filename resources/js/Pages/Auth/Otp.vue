<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

import {ref} from 'vue'
import VOtpInput from "vue3-otp-input";
let urlParams = new URLSearchParams(window.location.search);

const form = useForm({
    otp: null,
});


const otpInput = ref(null);

const error = ref('');

const handleOnComplete = (value) => {
    form.transform(data => ({
        otp: value,
        email: urlParams.get('email') ?? null,
    })).post(route('user.otp-verify'), {
        onError: function (res) {
            error.value = res.error;
        }
    });
};
</script>
<template>
    <Head>
        <title>OTP Verification</title>
    </Head>

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>
        <p class="mb-2 text-2xl font-semibold">Verify OTP</p>
        <p class="my-4 text-sm">Success! Your login attempt has been recognized. Check your email for the OTP (One-Time Password) we've sent to ensure secure access.</p>

        <p class="text-sm text-red-500 mb-4" v-if="!form.processing">{{error}}</p>
        <div style="display: flex; flex-direction: row">
            <v-otp-input
                ref="otpInput"
                input-classes="otp-input focus:border-black focus:ring-black"
                :conditionalClass="['one', 'two', 'three', 'four', 'five', 'six']"
                separator="-"
                inputType="letter-numeric"
                :num-inputs="6"
                :should-auto-focus="true"
                :should-focus-order="true"
                @on-complete="handleOnComplete"
                :placeholder="['*', '*', '*', '*', '*', '*']"
            />
        </div>

    </AuthenticationCard>
</template>
<style>
.otp-input {
    width: 40px;
    height: 40px;
    padding: 5px;
    margin: 0 10px;
    font-size: 20px;
    border-radius: 4px;
    border: 1px solid rgba(0, 0, 0, 0.3);
    text-align: center;
}
.otp-input::-webkit-inner-spin-button,
.otp-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input::placeholder {
    font-size: 15px;
    text-align: center;
    font-weight: 600;
}
</style>
