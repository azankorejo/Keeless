<script setup>
import ApiTokenManager from '@/Pages/API/Partials/ApiTokenManager.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    tokens: Array,
});
console.log(props.tokens)

</script>

<template>
    <AppLayout title="API Tokens">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                API Tokens
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 relative top-[180px]">
                <ApiTokenManager
                    :tokens="tokens"
                />
            </div>
        </div>
    </AppLayout>
</template>
