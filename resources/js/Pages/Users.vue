<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link, router, useForm} from "@inertiajs/vue3";
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import {ref} from 'vue'

const props = defineProps({
    users: Array,
    search: String,
    has_username: Boolean
})
const showModal = ref(false);
const selectedUser = ref(null);
const form = useForm({});

function toggleActivation(checked, user) {
    router.post(route('user.activation'), {
        _method: 'post',
        active: checked,
        uid: user.id
    });
}
function deleteUser() {
    console.log({
        _method: 'post',
        uid: selectedUser.id,
    })
    router.post(route('user.delete'), {
        _method: 'post',
        uid: selectedUser.value.id,
    }, {
        onSuccess: () => {
            closeModal()
        }
    });
}

function openModal (user) {
    selectedUser.value = user;
    showModal.value = true;
}
function closeModal (user) {
    selectedUser.value = null;
    showModal.value = false;
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

</script>
<template>
    <AppLayout title="Dashboard">
        <DialogModal :show="showModal" @close="closeModal()">
            <template #title>
                Confirm
            </template>

            <template #content>
                <div>
                    Are you sure you want to delete this user? You cannot undo this action.
                </div>

            </template>

            <template #footer>
                <SecondaryButton @click="closeModal()">
                    Close
                </SecondaryButton>
                <span class="px-3"></span>
                <PrimaryButton @click="deleteUser()">
                    Delete
                </PrimaryButton>
            </template>
        </DialogModal>
        <div class="bg-white overflow-hidden h-full mt-20 container">
            <div>
                <h1 class="text-2xl">Manage users</h1>
            </div>
            <div>
                <form action="" method="get" class="flex items-center gap-5 ml-1 w-1/2">
                    <TextInput
                        id="search"
                        name="search"
                        :value="search"
                        type="text"
                        class="mt-1 block w-full"
                        autofocus
                        placeholder="Search"
                        ref="search_input"
                    />
                    <PrimaryButton>
                        Search
                    </PrimaryButton>
                </form>
            </div>
            <div class="mb-5"></div>
            <div class="rounded">
                <div class="overflow-x-auto rounded-t-lg">
                    <table class="min-w-full divide-y-2  bg-white text-sm">
                        <thead class="text-left">
                        <tr>
                            <th v-if="has_username" class="whitespace-nowrap text-left font-medium text-gray-900 p-5">Name</th>
                            <th class="whitespace-nowrap text-left font-medium text-gray-900 p-5">Email</th>
                            <th class="whitespace-nowrap text-left font-medium text-gray-900 p-5">Registered at</th>
                            <th class="whitespace-nowrap text-left font-medium text-gray-900 p-5">Actions</th>
                        </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                        <tr v-for="(user) in users.data">
                            <td v-if="has_username" class="whitespace-nowrap p-5 text-gray-700">{{ user.username }}</td>
                            <td class="whitespace-nowrap p-5 text-gray-700">{{ user.email }}</td>
                            <td class="whitespace-nowrap p-5 text-gray-700">{{ formatDate(user.created_at) }}</td>
                            <td class="whitespace-nowrap p-5 text-gray-700 flex items-center gap-4">
                                <label class="inline-flex items-center cursor-pointer mt-2">
                                    <input type="checkbox" :checked="user.active" value="" v-on:change="toggleActivation($event.target.checked, user)"
                                           class="sr-only peer">
                                    <div
                                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black"></div>
                                </label>
                                <div  @click="openModal(user)">
                                    <svg xmlns="http://www.w3.org/2000/svg" title="Delete" width="24" height="24" fill="#000000" class="bi bi-trash2-fill cursor-pointer" viewBox="0 0 16 16">
                                        <path d="M2.037 3.225A.7.7 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2a.7.7 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671zm9.89-.69C10.966 2.214 9.578 2 8 2c-1.58 0-2.968.215-3.926.534-.477.16-.795.327-.975.466.18.14.498.307.975.466C5.032 3.786 6.42 4 8 4s2.967-.215 3.926-.534c.477-.16.795-.327.975-.466-.18-.14-.498-.307-.975-.466z"/>
                                    </svg>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="rounded-b-lg border-t border-gray-200 px-4 py-2">
                    <div v-if="users.data.length > 3">
                        <div class="flex flex-wrap">
                            <template v-for="(link, key) in users.links">
                                <div v-if="link.url === null" :key="key"
                                     class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                                     v-html="link.label"/>
                                <Link v-else
                                      class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded focus:border-indigo-500"
                                      :class="{ 'bg-black text-white': link.active }" :href="link.url"
                                      v-html="link.label"/>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
