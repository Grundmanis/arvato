'use client';

import { useAuthStore } from '@/store/authStore';
import { useEffect } from 'react';

export default function AuthInitializer() {
  const initAuth = useAuthStore((s) => s.initAuth);

  useEffect(() => {
    initAuth();
  }, [initAuth]);

  return null;
}
