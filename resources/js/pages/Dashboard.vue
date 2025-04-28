<script setup lang="ts">
import { Button } from "@/components/ui/button";
import AppLayout from "@/layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { ExternalLink } from "lucide-vue-next";

const links = [
  { label: "Linked Accounts", url: "/linked-accounts", title: "Go to linked accounts page" },
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
          :title="link.title"
          :href="link.url"
        >
          <Button>
            {{ link.label }}
            <ExternalLink />
          </Button>
        </Link>
      </div>
    </div>
  </AppLayout>
</template>
