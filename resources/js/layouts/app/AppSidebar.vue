<script setup lang="ts">
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from "@/components/ui/sidebar";
import { Home, KeyRound, Link2 } from "lucide-vue-next";
import { inject } from "vue";

const appVersion = inject<string>("appVersion");

const items = [
  {
    title: "Dashboard",
    url: "/dashboard",
    icon: Home,
  },
  {
    title: "Linked Accounts",
    url: "/linked-accounts",
    icon: Link2,
  },
];

const isItemActive = (url: string) => {
  const currentUrl = window.location.pathname;
  return currentUrl === url || currentUrl.startsWith(url + "/");
}
</script>

<template>
  <Sidebar>
    <SidebarHeader>
      <div class="flex flex-row items-center justify-center gap-2 rounded-full border-2 p-2">
        <KeyRound class="size-5" />
        <span class="text-sm font-bold">OAuth Manager</span>
      </div>
    </SidebarHeader>

    <SidebarContent>
      <SidebarGroup>
        <SidebarGroupLabel>Application</SidebarGroupLabel>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
              <SidebarMenuButton asChild :is-active="isItemActive(item.url)">
                <a :href="item.url">
                  <component :is="item.icon" />
                  <span>{{ item.title }}</span>
                </a>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>

    <SidebarFooter>
      <span class="text-center text-xs font-bold">Version {{ appVersion }}</span>
    </SidebarFooter>
  </Sidebar>
</template>
