<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import {useForm} from '@inertiajs/vue3';
import {ref} from 'vue';
import FormSectionStriped from '@/Components/FormSectionStriped.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {router} from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    branding: Object
})

const brandingForm = useForm({});
const logo = ref(null);
const favicon = ref(null);
const logoPreview = ref(props.branding.logo);
const faviconPreview = ref(props.branding.favicon);
const primaryColor = ref(props.branding.primary_color ?? '#000000');
const secondaryColor = ref(props.branding.secondary_color ?? '#FFFFFF');

const saved = ref(false);

const submitForm = async () => {
    router.post(route('branding.store'), {
        _method: 'put',
        data: {
            primaryColor: primaryColor.value,
            secondaryColor: secondaryColor.value,
            logo: logo.value,
            favicon: favicon.value,
        },
    }, {
        onSuccess: function (res) {
            saved.value = true;
            setTimeout(function () {
                saved.value = false;
            }, 1500)
        }
    })
};

const handleLogoChange = (event) => {
    const file = event.target.files[0];
    logoPreview.value = URL.createObjectURL(file);
    logo.value = file;
};

const handleFaviconChange = (event) => {
    const file = event.target.files[0];
    faviconPreview.value = URL.createObjectURL(file);
    favicon.value = file;
};
</script>

<template>
    <AppLayout title="Form">
        <div class="bg-white overflow-hidden h-full">
            <div class="flex flex-col mt-20 h-full">
                <div>
                    <h1 class="text-2xl">Customize Your Branding</h1>
                    <p>This branding will appear on the user facing pages, emails and the application pages.</p>
                </div>
                <div class="flex flex-col mt-20">
                    <FormSectionStriped @submit="submitForm" class="space-y-20 w-full">
                        <template #form>
                            <div class="flex flex-col gap-10">
                                <div class="flex items-center max-w-[1000px] w-[550px]">
                                    <label for="logo" class="w-full">Upload Logo:</label>
                                    <InputError :message="brandingForm.errors.logo" class="mt-2"/>

                                    <input type="file" id="logo" accept="image/*" @change="handleLogoChange" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
    file:bg-gray-50 file:border-0
    file:me-4
    file:py-3 file:px-4
    ">
                                    <img :src="logoPreview" v-if="logoPreview" alt="Logo Preview"
                                         class="w-12 h-12 ml-4 object-cover border border-gray-300 rounded-lg">
                                </div>
                                <div class="flex items-center max-w-[1000px] w-[550px]">
                                    <label for="favicon" class="w-full">Upload Favicon:</label>
                                    <InputError :message="brandingForm.errors.favicon" class="mt-2"/>

                                    <input type="file" id="favicon" accept="image/*" @change="handleFaviconChange"
                                           class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none
                                        file:bg-gray-50 file:border-0
                                        file:me-4
                                        file:py-3 file:px-4
                                        ">
                                    <img :src="faviconPreview" v-if="faviconPreview" alt="Favicon Preview"
                                         class="w-12 h-12 ml-4 object-cover border border-gray-300 rounded-lg">
                                </div>
                                <div class="flex items-center max-w-[1000px] w-[550px]">
                                    <label for="primaryColor" class="w-full">Primary Color:</label>
                                    <input type="color" id="primaryColor" v-model="primaryColor">
                                </div>
                                <div class="flex items-center max-w-[1000px] w-[550px]">
                                    <label for="secondaryColor" class="w-full">Secondary Color:</label>
                                    <input type="color" id="secondaryColor" v-model="secondaryColor">
                                </div>
                            </div>
                        </template>
                        <template v-if="true" #actions>
                            <ActionMessage :on="saved" class="me-3">
                                Saved.
                            </ActionMessage>

                            <PrimaryButton>
                                Save
                            </PrimaryButton>
                        </template>
                    </FormSectionStriped>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Add your custom styles here */
</style>
