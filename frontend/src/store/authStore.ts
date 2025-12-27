import { create } from 'zustand';
import { ensureAuth } from '@/lib/api/auth.api';

type AuthState = {
  isAuthenticated: boolean;
  initAuth: () => Promise<void>;
};

export const useAuthStore = create<AuthState>((set) => ({
  isAuthenticated: false,

  initAuth: async () => {
    try {
      await ensureAuth();
      set({ isAuthenticated: true });
    } catch {
      set({ isAuthenticated: false });
    }
  },
}));
