import axios from "@/lib/axios";
import { SocialAccount } from "@/types/socialAccount";

async function getLinkedAccounts(): Promise<SocialAccount[]> {
  return await axios
    .get("/linked-accounts/data")
    .then((response) => response.data)
    .catch((error) => {
      console.error("Error fetching linked accounts:", error);
      throw error;
    });
}

async function unlinkAccount(provider: string): Promise<void> {
  return await axios
    .post(`/auth/unlink/${provider}`)
    .then(() => {})
    .catch((error) => {
      console.error("Error unlinking account:", error);
      throw error;
    });
}

export default { getLinkedAccounts, unlinkAccount };
