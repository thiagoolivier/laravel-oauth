<script setup lang="ts">
import type { BreadcrumbItemType } from "@/types";
import AppHead from "./app/AppHead.vue";
import AppSidebar from "./app/AppSidebar.vue";
import { SidebarProvider, SidebarTrigger } from "@/components/ui/sidebar";
import AppHeader from "./app/AppHeader.vue";

interface Props {
  breadcrumbs?: BreadcrumbItemType[];
  title?: string;
}

withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
});


</script>

<template>
  <AppHead :title="title"/>
  <SidebarProvider>
    <AppSidebar />   

    <div class="w-full">
      <AppHeader />      
      <main>
        <slot />
      </main>
    </div>
  </SidebarProvider>
</template>
