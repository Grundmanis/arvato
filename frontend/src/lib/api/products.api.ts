import { Sort } from '@/types/product';
import api from './http';

export const getProducts = async () => {
  const { data } = await api.get('/products');
  return data;
};

export type ProductFilters = {
  name?: string;
  category?: { label: string; value: string }[];
};

export function buildProductQuery(filters: ProductFilters, sorting?: Sort[]): string {
  const params = new URLSearchParams();

  if (filters.name) {
    params.append('name', filters.name);
  }

  if (filters.category?.length) {
    params.append('category', filters.category.map((c) => c.value).join(','));
  }

  if (sorting?.length) {
    const sort = sorting[0];
    params.append(`order[${sort.id}]`, sort.desc ? 'desc' : 'asc');
  }

  return params.toString();
}

export async function fetchProductsFromApi(
  page: number,
  itemsPerPage: number,
  filters: ProductFilters,
  sorting: Sort[],
) {
  const query = buildProductQuery(filters, sorting);
  const { data } = await api.get(`/products?page=${page}&itemsPerPage=${itemsPerPage}&${query}`);
  return data;
}

export async function fetchProductByIdFromApi(id: number) {
  const { data } = await api.get(`/products/${id}`);
  return data;
}

export async function fetchProductCategories() {
  const { data } = await api.get(`/filters/products/categories`);
  return data;
}

export async function fetchProductNames() {
  const { data } = await api.get(`/filters/products/names`);
  return data;
}
