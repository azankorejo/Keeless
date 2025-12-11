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
                        Configure your application's basic information and authentication preferences. These settings will be used throughout your application to personalize the user experience.
                    </template>

                    <template #form>
                        <!-- Team Owner Information -->
                        <div class="col-span-6">
                            <InputLabel value=""/>
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Business Name"/>
                            <p class="text-sm text-gray-600 mt-1 mb-2">Enter your business or application name. This will be displayed to users during authentication and in email communications.</p>
                            <InputError :message="addBusinessDetailsForm.errors.name" class="mt-2"/>

                            <TextInput
                                v-model="addBusinessDetailsForm.name"
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="My Awesome App"
                                required
                            />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Subdomain"/>
                            <p class="text-sm text-gray-600 mt-1 mb-2">Choose a unique subdomain for your application. This will be used to create custom authentication pages (e.g., yoursubdomain.app.com).</p>
                            <InputError :message="addBusinessDetailsForm.errors.domain" class="mt-2"/>

                            <TextInput
                                v-model="addBusinessDetailsForm.domain"
                                id="domain"
                                type="text"
                                class="mt-1 block w-full"
                                placeholder="yoursubdomain"
                                required
                            />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <InputLabel for="name"
                                                value="Integration Method"/>
                                    <p class="text-sm text-gray-600 mt-1">Choose how you want to integrate authentication into your application.</p>
                                </div>
                                <div class="relative ml-2 mt-1">
                                    <button 
                                        type="button"
                                        @mouseenter="showApiTooltip = true" 
                                        @mouseleave="showApiTooltip = false"
                                        @focus="showApiTooltip = true"
                                        @blur="showApiTooltip = false"
                                        class="text-blue-500 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-full transition-colors duration-200"
                                        aria-label="More information about integration methods">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                             class="bi bi-info-circle" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                        </svg>
                                    </button>
                                    <transition
                                        enter-active-class="transition ease-out duration-200"
                                        enter-from-class="opacity-0 translate-y-1 scale-95"
                                        enter-to-class="opacity-100 translate-y-0 scale-100"
                                        leave-active-class="transition ease-in duration-150"
                                        leave-from-class="opacity-100 translate-y-0 scale-100"
                                        leave-to-class="opacity-0 translate-y-1 scale-95"
                                    >
                                        <div v-if="showApiTooltip" 
                                             role="tooltip"
                                             class="absolute right-0 top-8 z-50 w-80 p-4 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-xl shadow-xl">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0 mt-0.5">
                                                    <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="white" viewBox="0 0 16 16">
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-semibold text-gray-900 mb-2">Choose Your Integration Method</h4>
                                                    <div class="space-y-2 text-sm text-gray-700">
                                                        <div class="flex items-start">
                                                            <span class="font-semibold text-blue-600 mr-2">API Mode:</span>
                                                            <span>Build your own custom authentication interface using our RESTful API. Perfect for full control and custom user experiences.</span>
                                                        </div>
                                                        <div class="flex items-start">
                                                            <span class="font-semibold text-indigo-600 mr-2">Hosted Pages:</span>
                                                            <span>Use our pre-built, customizable authentication pages. Simply redirect users to our hosted login and registration pages.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="absolute -top-2 right-4 w-4 h-4 bg-gradient-to-br from-blue-50 to-indigo-50 border-l border-t border-blue-200 transform rotate-45"></div>
                                        </div>
                                    </transition>
                                </div>
                            </div>
                            <InputError :message="addBusinessDetailsForm.errors.use_api" class="mt-2"/>

                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" v-model="addBusinessDetailsForm.use_api" checked value=""
                                       class="sr-only peer">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900">Use API Integration</span>
                            </label>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name"
                                        value="User Information Collection"/>
                            <p class="text-sm text-gray-600 mt-1 mb-2">Enable this option to collect and store the user's name along with their email address during registration.</p>
                            <InputError :message="addBusinessDetailsForm.errors.use_name" class="mt-2"/>

                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" v-model="addBusinessDetailsForm.use_name" checked value=""
                                       class="sr-only peer">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900">Collect User Name</span>
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
                            <InputLabel for="name" value="Support Email"/>
                            <p class="text-sm text-gray-600 mt-1 mb-2">Optional: Provide a support email address that users can contact for assistance. This will be displayed in authentication-related communications.</p>
                            <InputError :message="addBusinessDetailsForm.errors.support_email" class="mt-2"/>

                            <TextInput
                                v-model="addBusinessDetailsForm.support_email"
                                id="support_email"
                                type="email"
                                class="mt-1 block w-full"
                                placeholder="support@yourdomain.com"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="terms_of_use" value="Terms of Service URL"/>
                            <p class="text-sm text-gray-600 mt-1 mb-2">Optional: Link to your terms of service page. Users will be able to access this during registration or authentication.</p>
                            <InputError :message="addBusinessDetailsForm.errors.terms_of_use" class="mt-2"/>

                            <TextInput
                                v-model="addBusinessDetailsForm.terms_of_use"
                                id="terms_of_use"
                                type="url"
                                class="mt-1 block w-full"
                                placeholder="https://yourdomain.com/terms"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="privacy_policy" value="Privacy Policy URL"/>
                            <p class="text-sm text-gray-600 mt-1 mb-2">Optional: Link to your privacy policy page. This helps build trust and ensures compliance with data protection regulations.</p>
                            <InputError :message="addBusinessDetailsForm.errors.privacy_policy" class="mt-2"/>
                            <TextInput
                                v-model="addBusinessDetailsForm.privacy_policy"
                                id="privacy_policy"
                                type="url"
                                class="mt-1 block w-full"
                                placeholder="https://yourdomain.com/privacy"
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
                        Email Configuration
                    </template>

                    <template #description>
                        Configure how authentication emails (OTP codes or magic links) are sent to your users. You can use your own SMTP server or our default email service.
                    </template>

                    <template #form>
                        <div class="col-span-6">
                            <InputLabel value=""/>
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Email Service Provider"/>
                            <p class="text-sm text-gray-600 mt-1 mb-2">Choose whether to use your own SMTP server or our default email service. Enable SMTP to send emails from your own domain.</p>
                            <InputError :message="addEmailsDetailsForm.errors.use_smtp" class="mt-2"/>
                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" value="" class="sr-only peer"
                                       v-model="addEmailsDetailsForm.use_smtp">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900">Use Custom SMTP Server</span>
                            </label>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <InputLabel for="name" value="Authentication Method"/>
                            <p class="text-sm text-gray-600 mt-1 mb-2">Select how users will authenticate: OTP (One-Time Password) codes or Magic Links. OTP requires users to enter a 6-digit code, while Magic Links allow one-click authentication.</p>
                            <InputError :message="addEmailsDetailsForm.errors.use_otp" class="mt-2"/>
                            <label class="inline-flex items-center cursor-pointer mt-2">
                                <input type="checkbox" value="" class="sr-only peer"
                                       v-model="addEmailsDetailsForm.use_otp">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                                <span
                                    class="ms-3 text-sm font-medium text-gray-900">Use OTP (One-Time Password)</span>
                            </label>
                        </div>
                        <template v-if="addEmailsDetailsForm.use_smtp">
                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="email" value="SMTP Email Address"/>
                                <p class="text-sm text-gray-600 mt-1 mb-2">The email address that will be used to send authentication emails to your users.</p>
                                <InputError :message="addEmailsDetailsForm.errors.email" class="mt-2"/>
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="addEmailsDetailsForm.email"
                                    placeholder="noreply@yourdomain.com"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="smtpServer" value="SMTP Server Host"/>
                                <p class="text-sm text-gray-600 mt-1 mb-2">Your SMTP server address (e.g., smtp.mailtrap.io, smtp.gmail.com, smtp.sendgrid.net).</p>
                                <InputError :message="addEmailsDetailsForm.errors.server" class="mt-2"/>
                                <TextInput
                                    id="smtpServer"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="addEmailsDetailsForm.server"
                                    placeholder="smtp.mailtrap.io"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="smtpPort" value="SMTP Port"/>
                                <p class="text-sm text-gray-600 mt-1 mb-2">The port number for your SMTP server. Common ports: 587 (TLS), 465 (SSL), or 2525 (Mailtrap).</p>
                                <InputError :message="addEmailsDetailsForm.errors.port" class="mt-2"/>
                                <TextInput
                                    id="smtpPort"
                                    type="number"
                                    class="mt-1 block w-full"
                                    v-model="addEmailsDetailsForm.port"
                                    placeholder="587"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="smtpUsername" value="Sender Name"/>
                                <p class="text-sm text-gray-600 mt-1 mb-2">The display name that will appear in the "From" field when users receive authentication emails.</p>
                                <InputError :message="addEmailsDetailsForm.errors.username" class="mt-2"/>
                                <TextInput
                                    id="smtpUsername"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="addEmailsDetailsForm.username"
                                    placeholder="Your App Name"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="smtpPassword" value="SMTP Password"/>
                                <p class="text-sm text-gray-600 mt-1 mb-2">The password or API key for your SMTP server. For Mailtrap, use your inbox password.</p>
                                <InputError :message="addEmailsDetailsForm.errors.password" class="mt-2"/>
                                <TextInput
                                    id="smtpPassword"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="addEmailsDetailsForm.password"
                                    placeholder="Enter your SMTP password"
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
                            API Domain Restrictions
                        </template>

                        <template #description>
                            Restrict API access to specific domains for enhanced security. Only requests originating from the domains listed below will be allowed when using your API key. Leave this empty to allow access from any domain (not recommended for production).
                        </template>

                        <template #form>
                            <div class="col-span-6">
                                <InputLabel value=""/>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <InputLabel for="login_redirect"
                                            value="Allowed Domains"/>
                                <p class="text-sm text-gray-600 mt-1 mb-2">Enter the full URLs (including http:// or https://) of domains that are allowed to make API requests. Each domain should be on a separate line or separated by commas.</p>
                                <InputError :message="addDomainForm.errors.domains" class="mt-2"/>
                                <TagsInput
                                    @data="(d) => addDomainForm.domains = d"
                                    id="domains"
                                    :value="addDomainForm.domains"
                                />
                                <p class="text-xs text-gray-500 mt-2">Example: https://yourdomain.com, https://app.yourdomain.com</p>
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
