<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import linkedAccountsService from "@/services/linkedAccountsService";
import { Button } from "@/components/ui/button";
import { Skeleton } from "@/components/ui/skeleton";
import { Table, TableBody, TableCaption, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { SocialAccount } from "@/types/socialAccount";
import { Link2Off } from "lucide-vue-next";
import { onMounted, ref } from "vue";

defineProps<{
  title: string;
}>();

const isMounted = ref(false);
const socialAccounts = ref<SocialAccount[]>();
const accountsLoaded = ref(false);

const handleLoadAccounts = async () => {
  socialAccounts.value = await linkedAccountsService.getLinkedAccounts();
  accountsLoaded.value = true;
};

const handleUnlinkAccount = async (provider: string) => {
  // Confirm the unlink action
  const confirmUnlink = confirm("Are you sure you want to unlink this account?");
  if (!confirmUnlink) return;

  // Call the unlink account API
  await linkedAccountsService
    .unlinkAccount(provider)
    .then(() => {
      alert("Account unlinked successfully.");
    })
    .catch((error) => {
      console.error("Error unlinking account:", error);
      alert("Failed to unlink account. Please try again.");
    });

  // After unlinking, refresh the accounts list
  await handleLoadAccounts();
};

onMounted(() => {
  handleLoadAccounts();
  isMounted.value = true;
});
</script>

<template>
  <AppLayout :title="title">
    <div class="flex flex-col gap-8 p-4">
      <h2>Linked Accounts</h2>

      <div class="flex flex-col items-center justify-center gap-4">
        <div v-if="isMounted && accountsLoaded" class="w-[800px] overflow-hidden rounded-lg border border-gray-200 p-4 shadow-sm">
          <Table>
            <TableCaption>
              {{ socialAccounts && socialAccounts.length > 0 ? 'A list of your linked accounts.' : 'No accounts found.' }}
            </TableCaption>

            <TableHeader>
              <TableRow>
                <TableHead class="font-bold">Provider name</TableHead>
                <TableHead class="text-center font-bold">Actions</TableHead>
              </TableRow>
            </TableHeader>

            <TableBody>
              <TableRow v-for="account in socialAccounts" :key="account.id">
                <TableHead class="font-medium whitespace-nowrap">
                  {{ account.provider_name.charAt(0).toUpperCase() + account.provider_name.slice(1) }}
                </TableHead>
                <TableHead class="text-center">
                  <Button 
                    size="sm" 
                    @click.prevent="handleUnlinkAccount(account.provider_name)" 
                    class="text-white hover:bg-red-300 dark:text-black"
                  >
                    <Link2Off />
                    Unlink
                  </Button>
                </TableHead>
              </TableRow>
            </TableBody>
          </Table>
        </div>

        <Skeleton v-else class="h-[400px] w-[800px] rounded-lg p-4" />
      </div>
    </div>
  </AppLayout>
</template>
