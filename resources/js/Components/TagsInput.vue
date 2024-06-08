<template>
    <div>
        <div class="pb-2 border border-white rounded-lg w-full relative">
            <input
                class="w-full border-gray-300 focus:border-black focus:ring-black rounded-md shadow-sm"
                v-model="newTag"
                placeholder="Add Domain"/>
            <div class="cursor-pointer absolute right-3 top-2" @click="addTag">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                     class="bi bi-plus-square" viewBox="0 0 16 16">
                    <path
                        d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
            </div>
            <div class="flex items-center flex-wrap mt-2">
                <span class="py-2 invisible">:</span>
                <span v-for="(tag, index) in tags" class="border-gray-300 border px-4 py-2 mr-1 rounded-full"
                      :key="index">
                    <button type="button" @click="deleteTag(tag)" class="mx-1 font-bold disabled">X</button>{{ tag }}
                  </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['value'],
    data() {
        return {
            newTag: '',
            tags: []
        }
    },
    mounted() {
        if(this.value.length > 0) {
            this.tags = this.value
        }
    },
    methods: {
        isValidUrl(string) {
            try {
                new URL(string);
                return true;
            } catch (err) {
                return false;
            }
        },
        addTag() {
            console.log('addTag', this.tags, this.newTag)
            if (!this.newTag || this.tags.includes(this.newTag) || !this.isValidUrl(this.newTag)) {
                return
            }
            this.tags.push(this.newTag);
            this.newTag = '';
            this.$emit('data', this.tags )
        },
        deleteTag(tag) {
            this.tags.splice(this.tags.indexOf(tag), 1);
        }
    }
}
</script>
