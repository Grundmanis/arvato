import { useEffect } from 'react';
import { ProductFilters } from '@/api/api';

export function useProductsFetcher(
  fetchProducts: (page: number, filters: ProductFilters, perPage?: number) => void,
  page: number,
  filters: ProductFilters,
  perPage: number,
) {
  useEffect(() => {
    fetchProducts(page, filters, perPage);
  }, [fetchProducts, page, filters, perPage]);
}
