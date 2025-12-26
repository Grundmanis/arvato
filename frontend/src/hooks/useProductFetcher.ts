import { useEffect } from 'react';
import { ProductFilters } from '@/api/api';
import { Sort } from '@/types/product';

export function useProductsFetcher(
  fetchProducts: (page: number, filters: ProductFilters) => void,
  setPage: (value: number) => void,
  page: number,
  filters: ProductFilters,
  perPage: number,
  sort: Sort[],
) {
  const sortKey = JSON.stringify(sort);

  useEffect(() => {
    fetchProducts(page, filters);
  }, [fetchProducts, page, filters, perPage, sortKey]);

  useEffect(() => {
    setPage(1);
  }, [filters]);
}
