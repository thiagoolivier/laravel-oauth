<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";

defineProps<{
  title: string;
}>();
</script>

<template>
  <AppLayout :title="title">
    <div class="flex flex-col gap-4 p-4">
      <h2>Account</h2>

      <div class="grid grid-cols-4 w-full">
        <div class="rounded border p-4">
          <span class="font-bold">Linked accounts</span>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
