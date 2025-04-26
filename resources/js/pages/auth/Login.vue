<script setup lang="ts">
import GoogleLogo from "@/assets/svg/GoogleLogo.vue";
import ThemeSwitch from "@/components/theme/ThemeSwitch.vue";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Separator } from "@/components/ui/separator";
import { useOAuthListener } from "@/composables/useOAuthListener";
import { useOAuthPopup } from "@/composables/useOAuthPopup";
import AuthLayout from "@/layouts/AuthLayout.vue";
import axios from "@/lib/axios";
import { refreshCsrfToken } from "@/services/refreshCsrfToken";
import { Head, router } from "@inertiajs/vue3";

const props = defineProps<{
  title: string;
  canResetPassword: boolean;
  status: string | null;
}>();

const { openOAuthPopup, isLoading, error } = useOAuthPopup()

useOAuthListener(() => {
  router.visit('/dashboard')
})

async function loginWithGoogle() {
  try {
    await refreshCsrfToken();
    const response = await axios.post("/auth/google/url");
    const providerUrl = response.data.url;

    if (!providerUrl) {
      throw new Error("Provider URL not found");
    }

    await openOAuthPopup({ url: providerUrl });
  } catch (error) {
    console.error(error);
    alert("Falha no login.");
  }
}
</script>

<template>
  <Head :title="title" />

  <ThemeSwitch class="float-right m-4" />

  <AuthLayout :title="`Tiga's OAuth2`" :description="'Making your OAuth life easier'">
    <Card>
      <CardHeader class="text-center">
        <CardTitle class="text-xl">Login</CardTitle>
        <CardDescription>Choose your prefered login method</CardDescription>
      </CardHeader>

      <CardContent>
        <form action="#" class="flex flex-col gap-3">
          <div class="flex flex-col gap-2">
            <Label for="email">Email</Label>
            <Input id="email" name="email" type="email" placeholder="mail@example.com" />
          </div>
          <div class="flex flex-col gap-2">
            <Label for="password">Password</Label>
            <Input id="password" name="password" type="password" placeholder="mail@example.com" />
          </div>
        </form>
      </CardContent>

      <Separator />

      <CardFooter>
        <div class="flex w-full flex-col gap-2">
          <Button>Login</Button>

          <span class="text-center text-xs">Or</span>

          <Button class="w-full gap-4" :disabled="isLoading" @click.prevent="loginWithGoogle">
            <GoogleLogo />
            {{ isLoading ? 'Autenticando...' : 'Login com Google' }}
          </Button>

          <p v-if="error" class="text-red-500 mt-2">{{ error }}</p>
        </div>
      </CardFooter>
    </Card>
  </AuthLayout>
</template>
