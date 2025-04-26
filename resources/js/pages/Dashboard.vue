<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";

const links = [
  { label: "Account", url: "/account", title: "Go to my account" },
  { label: "Settings", url: "/settings", title: "Go to settings" },
];

defineProps<{
  title: string;
}>();
</script>

<template>
  <AppLayout :title="'Dashboard'">
    <div class="flex flex-col gap-8 p-4">
      <h1>Dashboard</h1>

      <div class="grid grid-cols-3 gap-4">
        <Link
          v-for="link in links"
          :key="link.label"
          class="rounded-lg border bg-indigo-950 p-8 font-bold inset-ring-gray-400 transition-all hover:bg-indigo-900 hover:inset-ring-2"
          :title="link.title"
          :href="link.url"
        >
          {{ link.label }}
        </Link>
      </div>
    </div>
  </AppLayout>
</template>
