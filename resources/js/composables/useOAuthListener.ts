import { onBeforeUnmount, onMounted } from "vue";

export function useOAuthListener(onSuccess: () => void) {
  function handleMessage(event: MessageEvent) {
    if (event.origin !== window.location.origin) return;
    
    if (event.data.success) {
      onSuccess();
    }
  }

  onMounted(() => {
    window.addEventListener("message", handleMessage);
  });

  onBeforeUnmount(() => {
    window.removeEventListener("message", handleMessage);
  });
}
