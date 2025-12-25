import { createStore } from 'zustand/vanilla';
import { defaultInitState, ProductState, ProductStore, ProductType } from '@/types/product';
import { ProductFilters, fetchProductsFromApi, fetchProductByIdFromApi } from '@/api/api';

export const createProductStore = (initState: ProductState = defaultInitState) =>
  createStore<ProductStore>()((set, get) => ({
    ...initState,

    setGridType: (gridType: ProductType) => set({ gridType }),
    setPerPage: (perPage: number) => set({ perPage }),

    fetchProducts: async (page: number, filters: ProductFilters) => {
      set({ loading: true, error: null });
      try {
        const state = get();
        const data = await fetchProductsFromApi(page, state.perPage, filters);
        set({ products: data.member, totalProductCount: data.totalItems, loading: false });
      } catch (err: unknown) {
        if (err instanceof Error) {
          set({ error: err.message, loading: false });
        } else {
          set({ error: String(err), loading: false });
        }
      }
    },

    fetchProductById: async (id: number) => {
      set({ loading: true, error: null });
      try {
        const data = await fetchProductByIdFromApi(id);
        set({ currentProduct: data, loading: false });
      } catch (err: unknown) {
        if (err instanceof Error) {
          set({ error: err.message, loading: false });
        } else {
          set({ error: String(err), loading: false });
        }
      }
    },
  }));
