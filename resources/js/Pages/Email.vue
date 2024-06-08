<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {defineProps, ref} from "vue";
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import FormSectionStriped from '@/Components/FormSectionStriped.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import ActionMessage from '@/Components/ActionMessage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import {useForm} from "@inertiajs/vue3";
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    emails: Array,
    emailTemplate: String,
})

let templateForm, currentEmailTemplate;
if (props.emailTemplate.code) {
    templateForm = useForm(JSON.parse(props.emails.data.filter(e => e.code === props.emailTemplate.code)[0]?.answers));
    currentEmailTemplate = JSON.parse(props.emails.data.filter(e => e.code === props.emailTemplate.code)[0]?.answers)
} else {
    templateForm = useForm({});
    currentEmailTemplate = {}
}

const submitTemplateForm = () => {
    templateForm.post(route('template-info.store', {code: props.emailTemplate.code}), {
        errorBag: 'templateInfo',
        preserveScroll: true,
    });
}

</script>

<template>
    <AppLayout title="Dashboard">
        <div class="bg-white overflow-hidden h-full">
            <div class="flex flex-col mt-20 h-full">
                <span></span>
                <div>
                    <h1 class="text-2xl">Design your email.</h1>
                    <p>These emails will be sent to your users. For branding changes go to
                        <Link href="users" class="text-blue-600">branding</Link>
                        page
                    </p>
                </div>
                <div class="flex flex-col">
                    <Dropdown align="left" width="60" class="">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-md leading-4 font-medium rounded-md  bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                    Select template to edit
                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                                </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <div class="w-60">
                                <template v-for="(email, index) in emails.data">
                                    <DropdownLink :href="`?template=${email.code}`" class="z-50 relative">
                                        {{ email.name }}
                                    </DropdownLink>
                                </template>
                            </div>
                        </template>
                    </Dropdown>
                    <div class="flex items-center" :class="{'mt-40': !emailTemplate.code}">
                        <div class="w-full" v-html="props.emailTemplate.template"></div>
                        <div class="w-2/4" v-show="emailTemplate.code">
                            <div class="ml-5">
                                <h1>Save your changes to view them.</h1>
                            </div>
                            <FormSectionStriped @submit="submitTemplateForm">
                                <template #form>
                                    <div class="col-span-6">
                                        <InputLabel value=""/>
                                    </div>

                                    <div class="col-span-6 sm:col-span-4" v-if="currentEmailTemplate.greeting">
                                        <InputLabel for="login_redirect" value="Greeting"/>
                                        <InputError :message="templateForm.errors.greeting" class="mt-2"/>
                                        <TextInput
                                            id="greeting"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="templateForm.greeting"
                                            required
                                        />
                                    </div>
                                    <div class="col-span-6 sm:col-span-4" v-if="currentEmailTemplate.heading">
                                        <InputLabel for="login_redirect" value="Heading"/>
                                        <InputError :message="templateForm.errors.heading" class="mt-2"/>
                                        <TextInput
                                            id="heading"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="templateForm.heading"
                                            required
                                        />
                                    </div>
                                    <div class="col-span-6 sm:col-span-4" v-if="currentEmailTemplate.subheading">
                                        <InputLabel for="login_redirect" value="Sub heading"/>
                                        <InputError :message="templateForm.errors.subheading" class="mt-2"/>
                                        <TextInput
                                            id="subheading"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="templateForm.subheading"
                                            required
                                        />
                                    </div>
                                    <div class="col-span-6 sm:col-span-4" v-if="currentEmailTemplate.button_text">
                                        <InputLabel for="login_redirect" value="Button text"/>
                                        <InputError :message="templateForm.errors.button_text" class="mt-2"/>
                                        <TextInput
                                            id="button_text"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="templateForm.button_text"
                                            required
                                        />
                                    </div>
                                    <div class="col-span-6 sm:col-span-4" v-if="currentEmailTemplate.footer_text">
                                        <InputLabel for="logout_redirect" value="Footer text"/>
                                        <InputError :message="templateForm.errors.footer_text" class="mt-2"/>
                                        <TextInput
                                            id="footer_text"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="templateForm.footer_text"
                                            required
                                        />
                                    </div>

                                </template>
                                <template v-if="true" #actions>
                                    <ActionMessage :on="templateForm.recentlySuccessful" class="me-3">
                                        Saved.
                                    </ActionMessage>

                                    <PrimaryButton :class="{ 'opacity-25': templateForm.processing }"
                                                   :disabled="templateForm.processing">
                                        Save
                                    </PrimaryButton>
                                </template>
                            </FormSectionStriped>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
