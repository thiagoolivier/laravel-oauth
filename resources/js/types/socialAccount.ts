import { User } from "./auth";

export interface SocialAccount {
  id: number;
  provider_name: string;
  provider_id: string;
  token: string;
  refresh_token: string;
  expires_at: string;
  user_id: number;
  created_at: string;
  updated_at: string;
  user?: User;
}
