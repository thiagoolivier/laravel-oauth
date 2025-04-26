<script setup lang="ts">
import { Moon, Sun } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';

const isDarkMode = ref(false);

onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    
    if (savedTheme === 'dark') {
        isDarkMode.value = true;
        document.documentElement.classList.remove('light');
        document.documentElement.classList.add('dark');
    } else {
        isDarkMode.value = false;
        document.documentElement.classList.add('light');
        document.documentElement.classList.remove('dark');
    }
});

function toggleTheme() {
    isDarkMode.value = !isDarkMode.value;
    document.documentElement.classList.toggle('dark', isDarkMode.value);
    localStorage.setItem('theme', isDarkMode.value ? 'dark' : 'light');
}
</script>

<template>
    <button class="p-1 rounded-full hover:bg-slate-300 dark:hover:bg-slate-700" @click.prevent="toggleTheme">
        <Sun v-if="isDarkMode"/>
        <Moon v-else/>
    </button>
</template>