<script setup lang="ts">
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuShortcut,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import { SidebarTrigger } from "@/components/ui/sidebar";
import { Link, usePage } from "@inertiajs/vue3";
import { UserIcon } from "lucide-vue-next";
import { ref } from "vue";

const page = usePage();
const user = page.props.auth?.user;

const isDrowdownOpen = ref(false);
</script>

<template>
  <header class="bg- flex w-full flex-row items-center justify-between border-y p-2">
    <div class="flex flex-row items-center gap-2">
      <SidebarTrigger />
      <span>Simple / Breadcrumb</span>
    </div>

    <DropdownMenu>
      <DropdownMenuTrigger as-child>
        <button class="flex flex-row items-center gap-2 rounded-full border-2 p-2 hover:cursor-pointer">
          <UserIcon />
          <span>{{ user.name }}</span>
        </button>
      </DropdownMenuTrigger>

      <DropdownMenuContent class="min-w-[200px]">
        <DropdownMenuLabel>My account</DropdownMenuLabel>
        <DropdownMenuSeparator />

        <DropdownMenuGroup>
          <DropdownMenuItem>
            <span>Linked accounts</span>
          </DropdownMenuItem>
        </DropdownMenuGroup>

        <DropdownMenuSeparator />

        <DropdownMenuItem>
          <Link class="flex flex-row items-center w-full hover:cursor-pointer" :href="route('logout', )" method="post">
            <span>Logout</span>
            <DropdownMenuShortcut class="float-end">⇧⌘P</DropdownMenuShortcut>
          </Link>
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>
  </header>
</template>
