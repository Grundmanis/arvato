import { createStore } from 'zustand/vanilla';
import { defaultInitState, ProductState, ProductStore, ProductType, Sort } from '@/types/product';
import {
  fetchProductByIdFromApi,
  fetchProductsFromApi,
  ProductFilters,
} from '@/lib/api/products.api';

export const createProductStore = (initState: ProductState = defaultInitState) =>
  createStore<ProductStore>()((set, get) => ({
    ...initState,

    setGridType: (gridType: ProductType) => set({ gridType }),
    setPerPage: (perPage: number) => set({ perPage }),
    setSort: (sort: Sort[]) => set({ sort }),

    fetchProducts: async (page: number, filters: ProductFilters) => {
      set({ loading: true, error: null });
      try {
        const state = get();
        const data = await fetchProductsFromApi(page, state.perPage, filters, state.sort);
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
