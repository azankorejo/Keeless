<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    mau: String,
    userCount: String,
    rrLastMonth: String,
    rrAllTime: String,
})

</script>

<template>
    <AppLayout title="Dashboard">
        <div class="bg-white overflow-hidden h-full">
            <div class="flex flex-col gap-20 h-full">
                <span></span>
                <div>
                    <h1 class="text-2xl">Hello, welcome {{ $page.props.auth.user.name }}</h1>
                    <p>Setup your app to get started. watch tutorial here</p>
                </div>
                <div class="flex flex-col  gap-10">
                    <div class="flex gap-10 flex-col md:flex-row">
                        <div class="flex w-full max-w-[450px] gap-10 rounded-2xl p-10 shadow border border-gray-300">
                            <div class="flex flex-col gap-1">
                                <h1 class="text- font-semibold">Monthly Active Users</h1>
                                <h1 class="">Last 30 days</h1>
                                <p class="text-3xl font-semibold">{{ props.mau }}</p>
                            </div>
                        </div>
                        <div class="flex w-full max-w-[450px] gap-10 rounded-2xl p-10 shadow border border-gray-300">
                            <div class="flex flex-col gap-1">
                                <h1 class="text- font-semibold">All Users</h1>
                                <h1 class="">All Time</h1>
                                <p class="text-3xl font-semibold">{{ props.userCount }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-10 flex-col md:flex-row">
                        <div class="justifycenter flex w-full max-w-[450px] gap-10 rounded-2xl p-10 shadow border border-gray-300">
                            <div class="flex flex-col gap-1">
                                <h1 class="text- font-semibold">Retention Rate</h1>
                                <h1 class="">Last 30 days</h1>
                                <p class="text-3xl font-semibold">{{ props.rrLastMonth }}</p>
                            </div>
                        </div>
                        <div class="justifycenter flex w-full max-w-[450px] gap-10 rounded-2xl p-10 shadow border border-gray-300">
                            <div class="flex flex-col gap-1">
                                <h1 class="text- font-semibold">Retention Rate</h1>
                                <h1 class="">All Time</h1>
                                <p class="text-3xl font-semibold">{{ props.rrAllTime }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
