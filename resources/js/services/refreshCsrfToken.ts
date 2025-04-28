import axios from "axios";

export async function refreshCsrfToken() {
  const response = await axios.get("/csrf-token-refresh");
  const newToken = response.data.csrf_token;

  if (newToken) {
    axios.defaults.headers.common["X-CSRF-TOKEN"] = newToken;
    document.querySelector('meta[name="csrf-token"]')?.setAttribute("content", newToken);
  }
}
