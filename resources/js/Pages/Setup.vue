<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import MultiSelect from "@/Components/MultiSelect.vue";
import ActionMessage from '@/Components/ActionMessage.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import InputError from '@/Components/InputError.vue';
import TagsInput from '@/Components/TagsInput.vue';

import {ref} from "vue";
import {router, useForm} from "@inertiajs/vue3";

const props = defineProps({
    data: Object,
});
router.reload({only: ['data']})

const showApiTooltip = ref(false);
const value = ref([]);
const addBusinessDetailsForm = useForm(props.data.data.business_info);
const addEmailsDetailsForm = useForm(props.data.data.email_info);
const addRedirectionDetailsForm = useForm(props.data.data.redirection_info);
const addDomainForm = useForm({domains: props.data.data.permitted_domains});
const jwtConfigSetup = useForm({jwt_expiration: props.data.data.jwt_expiration});

const addJWTConfig = () => {
    jwtConfigSetup.post(route('jwt-config.store'), {
        errorBag: 'addJWTConfig',
        preserveScroll: true,
    });
};


const addRedirectionDetails = () => {
    addRedirectionDetailsForm.post(route('redirection.store'), {
        errorBag: 'addRedirectionDetails',
        preserveScroll: true,
    });
};

const addDomainInfo = () => {
    addDomainForm.post(route('domains.store'), {
        errorBag: 'addDomainInfo',
        preserveScroll: true,
    });
};

const addEmailsDetails = () => {
    addEmailsDetailsForm.post(route('email-info.store'), {
        errorBag: 'addEmailsDetails',
        preserveScroll: true,
    });
};

const addBusinessDetails = () => {
    addBusinessDetailsForm.post(route('business.store'), {
        errorBag: 'addBusinessDetails',
        preserveScroll: true,
    });
};

const options = ref([
    "Phone",
    "Username",
]);
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="bg-white overflow-hidden h-full">
            <div class="flex flex-col mt-20 h-full">
                <span></span>
                <div>
                    <h1 class="text-2xl">Setup your app to get started</h1>
                    <p>{{ $page.props.stepsDone }}/5 Done</p>
                </div>
                <div class="mt-20"></div>
                <FormSection @submit="addBusinessDetails">
                    <template #title>
                        <span >{{ $page.props.auth.user.current_team.name }}</span>
                    </template>

                    <template #description>
                        Add details for your app.
                    </template>

                    <template #form>
                        <!-- Team Owner Information -->
                        <div class="col-span-6">
                            <InputLabel value=""/>
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Business Name"/>
                            <InputError :message="addBusinessDetailsForm.errors.name" class="mt-2"/>

                            <TextInput
                                v-model="addBusinessDetailsForm.name"
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Domain"/>
                            <InputError :message="addBusinessDetailsForm.errors.domain" class="mt-2"/>

                            <TextInput
                                v-model="addBusinessDetailsForm.domain"
                                id="domain"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <div class="flex justify-between items-center">
                                <InputLabel for="name"
                                            value="Do you want to use API or our custom authentication pages"/>
                                <div class="relative">
                                    <svg @mouseover="showApiTooltip = true" @mouseleave="showApiTooltip = false"
                                         xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-info-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path
                                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                    </svg>
                                    <div id="tooltip-default" role="tooltip" v-if="showApiTooltip"
                                         class="absolute right-0 z-10 inline-block w-[300px] px-3 py-2 text-sm font-medium transition-opacity duration-300 bg-white border border-gray-300 rounded-lg shadow-sm tooltip">
                                        1. Utilize our API to design your own interface and interact with our services directly via requests outlined in our documentation.
                                        <br>
                                        2. Alternatively, use our pre-built screens for simplified implementation. Redirect your users to our hosted login, register, and other pages effortlessly.
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                            </div>
                            <InputError :message="addBusinessDetailsForm.errors.use_api" class="mt-2"/>

                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" v-model="addBusinessDetailsForm.use_api" checked value=""
                                       class="sr-only peer">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900">Use API</span>
                            </label>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <div class="flex justify-between items-center">
                                <InputLabel for="name"
                                            value="Do you want to get users name along with email?"/>
                            </div>
                            <InputError :message="addBusinessDetailsForm.errors.use_name" class="mt-2"/>

                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" v-model="addBusinessDetailsForm.use_name" checked value=""
                                       class="sr-only peer">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900">Get name</span>
                            </label>
                        </div>
<!--                        <div class="col-span-6 sm:col-span-4">-->
<!--                            <InputLabel for="name" value="Select fields to get from registering users (email is auto added)"/>-->
<!--                            <InputError :message="addBusinessDetailsForm.errors.fields" class="mt-2"/>-->
<!--                            <MultiSelect-->
<!--                                :formFieldName="'register_fields'"-->
<!--                                :options="options"-->
<!--                                :selected-items="addBusinessDetailsForm.fields"-->
<!--                                @change="(e) => addBusinessDetailsForm.fields = e.value"-->
<!--                            />-->
<!--                        </div>-->
<!--                        <div class="col-span-6 sm:col-span-4">-->
<!--                            <InputLabel for="name" value="Select fields used to login users (email is auto added)"/>-->
<!--                            <small>select register fields first.</small>-->
<!--                            <InputError :message="addBusinessDetailsForm.errors.login_fields" class="mt-2"/>-->
<!--                            <MultiSelect-->
<!--                                :formFieldName="'login_fields'"-->
<!--                                :options="addBusinessDetailsForm.fields"-->
<!--                                :selected-items="addBusinessDetailsForm.login_fields"-->
<!--                                @change="(e) => addBusinessDetailsForm.login_fields = e.value"-->
<!--                            />-->
<!--                        </div>-->
<!--                        <div class="col-span-6 sm:col-span-4">-->
<!--                            <InputLabel for="name" value="Website URL (optional)"/>-->
<!--                            <InputError :message="addBusinessDetailsForm.errors.web_url" class="mt-2"/>-->

<!--                            <TextInput-->
<!--                                v-model="addBusinessDetailsForm.web_url"-->
<!--                                id="web_url"-->
<!--                                type="text"-->
<!--                                class="mt-1 block w-full"-->
<!--                            />-->
<!--                        </div>-->
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Support Email (optional)"/>
                            <InputError :message="addBusinessDetailsForm.errors.support_email" class="mt-2"/>

                            <TextInput
                                v-model="addBusinessDetailsForm.support_email"
                                id="support_email"
                                type="text"
                                class="mt-1 block w-full"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="terms_of_use" value="Terms of use (optional)"/>
                            <InputError :message="addBusinessDetailsForm.errors.terms_of_use" class="mt-2"/>

                            <TextInput
                                v-model="addBusinessDetailsForm.terms_of_use"
                                id="terms_of_use"
                                type="text"
                                class="mt-1 block w-full"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="privacy_policy" value="Privacy Policy (optional)"/>
                            <InputError :message="addBusinessDetailsForm.errors.privacy_policy" class="mt-2"/>
                            <TextInput
                                v-model="addBusinessDetailsForm.privacy_policy"
                                id="privacy_policy"
                                type="text"
                                class="mt-1 block w-full"
                            />
                        </div>
                    </template>
                    <template v-if="true" #actions>

                        <ActionMessage :on="addBusinessDetailsForm.recentlySuccessful" class="me-3">
                            Saved.
                        </ActionMessage>

                        <PrimaryButton :class="{ 'opacity-25': addBusinessDetailsForm.processing }"
                                       :disabled="addBusinessDetailsForm.processing">
                            Save
                        </PrimaryButton>
                    </template>
                </FormSection>
                <SectionBorder/>
                <FormSection @submit="addEmailsDetails">
                    <template #title>
                        Email
                    </template>

                    <template #description>
                        Setup email for your app.
                    </template>

                    <template #form>
                        <div class="col-span-6">
                            <InputLabel value=""/>
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Use your own email or our email (no-reply@app.com)"/>
                            <InputError :message="addEmailsDetailsForm.errors.use_smtp" class="mt-2"/>
                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" value="" class="sr-only peer"
                                       v-model="addEmailsDetailsForm.use_smtp">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900">SMTP</span>
                            </label>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Do you prefer magic links or otp"/>
                            <InputError :message="addEmailsDetailsForm.errors.use_otp" class="mt-2"/>
                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" value="" class="sr-only peer"
                                       v-model="addEmailsDetailsForm.use_otp">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900">OTP</span>
                            </label>
                        </div>
                        <template v-if="addEmailsDetailsForm.use_smtp">
                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="email" value="Email Address"/>
                                <InputError :message="addEmailsDetailsForm.errors.email" class="mt-2"/>
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="addEmailsDetailsForm.email"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="smtpServer" value="SMTP Server"/>
                                <InputError :message="addEmailsDetailsForm.errors.server" class="mt-2"/>
                                <TextInput
                                    id="smtpServer"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="addEmailsDetailsForm.server"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="smtpPort" value="SMTP Port"/>
                                <InputError :message="addEmailsDetailsForm.errors.port" class="mt-2"/>
                                <TextInput
                                    id="smtpPort"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="addEmailsDetailsForm.port"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="smtpUsername" value="Send email as (Name)"/>
                                <InputError :message="addEmailsDetailsForm.errors.username" class="mt-2"/>
                                <TextInput
                                    id="smtpUsername"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="addEmailsDetailsForm.username"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="smtpPassword" value="SMTP Password"/>
                                <InputError :message="addEmailsDetailsForm.errors.password" class="mt-2"/>
                                <TextInput
                                    id="smtpPassword"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="addEmailsDetailsForm.password"
                                />
                            </div>
                        </template>
                    </template>
                    <template v-if="true" #actions>
                        <ActionMessage :on="addEmailsDetailsForm.recentlySuccessful" class="me-3">
                            Saved.
                        </ActionMessage>

                        <PrimaryButton :class="{ 'opacity-25': addEmailsDetailsForm.processing }"
                                       :disabled="addEmailsDetailsForm.processing">
                            Save
                        </PrimaryButton>
                    </template>
                </FormSection>
                    <SectionBorder/>
                    <FormSection @submit="addRedirectionDetails">
                        <template #title>
                            Setup redirection.
                        </template>

                        <template #description>
                            Setting up redirection means where to send the user after they've logged in or logged out. You can add your custom pages like dashboard url or any other page according to your needs.
                        </template>

                        <template #form>
                            <div class="col-span-6">
                                <InputLabel value=""/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="login_redirect" value="Redirect after login"/>
                                <InputError :message="addRedirectionDetailsForm.errors.login" class="mt-2"/>
                                <TextInput
                                    id="login_redirect"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="addRedirectionDetailsForm.login"
                                />
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="logout_redirect" value="Redirect after logout"/>
                                <InputError :message="addRedirectionDetailsForm.errors.logout" class="mt-2"/>
                                <TextInput
                                    id="logout_redirect"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="addRedirectionDetailsForm.logout"
                                />
                            </div>

                        </template>
                        <template v-if="true" #actions>
                            <ActionMessage :on="addRedirectionDetailsForm.recentlySuccessful" class="me-3">
                                Saved.
                            </ActionMessage>

                            <PrimaryButton :class="{ 'opacity-25': addRedirectionDetailsForm.processing }"
                                           :disabled="addRedirectionDetailsForm.processing">
                                Save
                            </PrimaryButton>
                        </template>
                    </FormSection>
                    <SectionBorder/>
                    <FormSection @submit="addDomainInfo">
                        <template #title>
                            Permitted domains for your API
                        </template>

                        <template #description>
                            Set up domains that you should be able to access our service from using an API key. Keeping it empty means it's not accessible from every domain, which is a security measure implemented to prevent malicious actors from obtaining your API key and using it to your disadvantage.
                        </template>

                        <template #form>
                            <div class="col-span-6">
                                <InputLabel value=""/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="login_redirect"
                                            value="Add Domains (add valid urls starting with http)"/>
                                <InputError :message="addDomainForm.errors.domains" class="mt-2"/>
                                <TagsInput
                                    @data="(d) => addDomainForm.domains = d"
                                    id="domains"
                                    :value="addDomainForm.domains"
                                />

                            </div>

                        </template>
                        <template v-if="true" #actions>
                            <ActionMessage :on="addDomainForm.recentlySuccessful" class="me-3">
                                Saved.
                            </ActionMessage>

                            <PrimaryButton :class="{ 'opacity-25': addDomainForm.processing }"
                                           :disabled="addDomainForm.processing">
                                Save
                            </PrimaryButton>
                        </template>
                    </FormSection>

                    <SectionBorder/>
                    <FormSection @submit="addJWTConfig">
                        <template #title>
                            JWT Token Config
                        </template>

                        <template #description>
                            Update your jwt config according to your needs.
                        </template>

                        <template #form>
                            <div class="col-span-6">
                                <InputLabel value=""/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="jwt_expiration" value="JWT Expiration Time (in days)"/>
                                <InputError :message="jwtConfigSetup.errors.jwt_expiration" class="mt-2"/>

                                <TextInput
                                    v-model="jwtConfigSetup.jwt_expiration"
                                    id="jwt_expiration"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                            </div>

                        </template>
                        <template v-if="true" #actions>
                            <ActionMessage :on="jwtConfigSetup.recentlySuccessful" class="me-3">
                                Saved.
                            </ActionMessage>

                            <PrimaryButton :class="{ 'opacity-25': jwtConfigSetup.processing }"
                                           :disabled="jwtConfigSetup.processing">
                                Save
                            </PrimaryButton>
                        </template>
                    </FormSection>

                <div class="mt-20"></div>

            </div>
        </div>
    </AppLayout>
</template>
