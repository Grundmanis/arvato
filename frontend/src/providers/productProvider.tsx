'use client';

import { createProductStore } from '@/store/productStore';
import { ProductStore } from '@/types/product';
import { type ReactNode, createContext, useState, useContext } from 'react';
import { useStore } from 'zustand';

export type ProductStoreApi = ReturnType<typeof createProductStore>;

export const ProductStoreContext = createContext<ProductStoreApi | undefined>(undefined);

export interface ProductStoreProviderProps {
  children: ReactNode;
}

export const ProductStoreProvider = ({ children }: ProductStoreProviderProps) => {
  const [store] = useState(() => createProductStore());
  return <ProductStoreContext.Provider value={store}>{children}</ProductStoreContext.Provider>;
};

export const useProductStore = <T,>(selector: (store: ProductStore) => T): T => {
  const productStoreContext = useContext(ProductStoreContext);
  if (!productStoreContext) {
    throw new Error(`useProductStore must be used within ProductStoreProvider`);
  }

  return useStore(productStoreContext, selector);
};
