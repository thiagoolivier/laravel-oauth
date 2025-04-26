import { ref } from "vue";

interface OAuthOptions {
  url: string;
  width?: number;
  height?: number;
  timeoutMs?: number;
}

export function useOAuthPopup() {
  const isLoading = ref(false);
  const error = ref<string | null>(null);

  function openOAuthPopup({ url, width = 500, height = 600, timeoutMs = 60000 }: OAuthOptions): Promise<void> {
    isLoading.value = true;
    error.value = null;

    return new Promise((resolve, reject) => {
      const left = window.screen.width / 2 - width / 2;
      const top = window.screen.height / 2 - height / 2;
      let isResolvedOrRejected = false;

      const popup = window.open(url, "OAuthLogin", `width=${width},height=${height},top=${top},left=${left}`);

      if (!popup) {
        isLoading.value = false;
        error.value = "Não foi possível abrir o pop-up.";
        reject(new Error("Popup bloqueado"));
        return;
      }

      const timeoutId = setTimeout(() => {
        if (!isResolvedOrRejected) {
          isResolvedOrRejected = true;
          clearInterval(checkPopupClosed);
          window.removeEventListener("message", handleMessage);
          isLoading.value = false;
          popup.close();
          error.value = "Login expirou. Tente novamente.";
          reject(new Error("Timeout"));
        }
      }, timeoutMs);

      function handleMessage(event: MessageEvent) {
        if (!popup) {
          clearTimeout(timeoutId);
          window.removeEventListener("message", handleMessage);
          isLoading.value = false;
          error.value = "Popup fechado inesperadamente.";
          reject(new Error("Popup closed unexpectedly"));
          return;
        }
        
        if (event.origin !== window.location.origin) {
          return;
        }
      
        if (event.data.success) {
          clearTimeout(timeoutId);
          window.removeEventListener("message", handleMessage);
          isLoading.value = false;
      
          try {
            popup.close();
          } catch (e) {
            console.warn('Não foi possível fechar o popup programaticamente:', e);
          }
      
          resolve();
        }
      }

      window.addEventListener("message", handleMessage);

      const checkPopupClosed = setInterval(() => {
        if (popup.closed && !isResolvedOrRejected) {
          isResolvedOrRejected = true;
          clearTimeout(timeoutId);
          window.removeEventListener("message", handleMessage);
          clearInterval(checkPopupClosed);
          isLoading.value = false;
          error.value = "Login cancelado.";
          reject(new Error("Popup fechado"));
        }
      }, 500);
    });
  }

  return { isLoading, error, openOAuthPopup };
}
