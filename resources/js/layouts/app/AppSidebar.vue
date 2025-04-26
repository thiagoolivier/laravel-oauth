<script setup lang="ts">
import { Sidebar, SidebarContent, SidebarFooter, SidebarGroup, SidebarHeader } from "@/components/ui/sidebar";
import { KeyRound } from "lucide-vue-next";
import { inject } from "vue";

const appVersion = inject<string>('appVersion');
</script>

<template>
  <Sidebar>
    <SidebarHeader>
      <div class="flex flex-row items-center justify-center gap-2 rounded-full border-2 p-2">
        <KeyRound class="size-5"/>
        <span class="text-sm font-bold">OAuth Manager</span>
      </div>
    </SidebarHeader>

    <SidebarContent>
      <SidebarGroup />
      <SidebarGroup />
    </SidebarContent>

    <SidebarFooter>
      <span class="text-center text-xs font-bold">Version {{ appVersion }}</span>
    </SidebarFooter>
  </Sidebar>
</template>
