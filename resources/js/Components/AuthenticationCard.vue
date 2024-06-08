<template>
    <div class="bg-[#FEFDFE] min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <slot name="logo" />
        </div>

        <div class="shadow-sm w-full sm:max-w-md mt-6 bg-white py-20 px-10 overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>
