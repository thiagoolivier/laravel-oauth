import axios from "axios";

const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

if (token) {
  axios.defaults.headers.common["X-CSRF-TOKEN"] = token;
} else {
  console.error('CSRF token não encontrado. Verifique o <meta name="csrf-token"> no seu HTML.');
}

axios.defaults.withCredentials = true;

export default axios;
