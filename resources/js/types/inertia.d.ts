import { PageProps } from '@inertiajs/inertia'
import { User } from './auth'

declare module '@inertiajs/core' {
  interface PageProps {
    auth: {
      user: User
    }
  }
}