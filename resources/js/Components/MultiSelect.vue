<script setup>
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import {onMounted, onUnmounted, ref} from "vue";

const props = defineProps({
    options: Array,
    selectedItems: Array
})
const emit = defineEmits(['change'])

let isOpen = ref(false);
const selectedOptions = ref([]);
let selectedText = ref("");
const dropdownRef = ref(null);
selectedOptions.value = (props.selectedItems);
selectedText = selectedOptions.value.join(", ");

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

const isChecked = (option) => selectedOptions.value.includes(option);

// Handle checkbox change
const handleCheckboxChange = (option) => {
    if (isChecked(option)) {
        selectedOptions.value = selectedOptions.value.filter((item) => item !== option);
    } else {
        selectedOptions.value.push(option);
    }
    selectedText = selectedOptions.value.join(", ");
    emit("change", selectedOptions);
};

function handleClickOutside(event) {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        isOpen.value = false;
    }
}

function toggleDropdown() {
    isOpen.value = !isOpen.value;
}
</script>

<template>
    <div class="relative" ref="dropdownRef">
        <TextInput type="text" class="w-full" v-model="selectedText" @click="toggleDropdown" readonly/>
        <div v-if="isOpen" class="dropdown">
            <ul>
                <li v-for="(option, index) in options" :key="index">
                    <label class="option-label">
                        <Checkbox :checked="isChecked(option)" @change="handleCheckboxChange(option)" :value="option" />
                        {{ option }}
                    </label>
                </li>
            </ul>
        </div>
    </div>
</template>


<style scoped>
.dropdown {
    position: absolute;
    top: calc(100% + 5px);
    left: 0;
    z-index: 10;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
}

.dropdown ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.option-label {
    display: block;
    padding: 0.5rem;
    cursor: pointer;
}

.checkbox {
    margin-right: 0.5rem;
}
</style>
