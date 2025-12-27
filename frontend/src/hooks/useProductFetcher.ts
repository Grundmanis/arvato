import { useEffect } from 'react';
import { Sort } from '@/types/product';
import { ProductFilters } from '@/lib/api/products.api';

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
  }, [filters, setPage]);
}
