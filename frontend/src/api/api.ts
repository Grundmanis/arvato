import { Sort } from '@/types/product';

const API_URL = process.env.NEXT_PUBLIC_API_URL;

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
  let token = '';
  if (!token) {
    token = await login();
  }

  const query = buildProductQuery(filters, sorting);
  const res = await fetch(
    `${API_URL}/api/products?page=${page}&itemsPerPage=${itemsPerPage}&${query}`,
    {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    },
  );
  if (!res.ok) throw new Error('Failed to fetch products');
  return res.json();
}

export async function fetchProductByIdFromApi(id: number) {
  let token = localStorage.getItem('jwt');
  if (!token) {
    token = await login();
  }
  const res = await fetch(`${API_URL}/api/products/${id}`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
  if (!res.ok) throw new Error('Failed to fetch product');
  return res.json();
}

export async function fetchProductCategories() {
  let token = localStorage.getItem('jwt');
  if (!token) {
    token = await login();
  }
  const res = await fetch(`${API_URL}/api/filters/products/categories`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
  if (!res.ok) throw new Error('Failed to fetch product');
  return res.json();
}

export async function fetchProductNames() {
  let token = localStorage.getItem('jwt');
  if (!token) {
    token = await login();
  }
  const res = await fetch(`${API_URL}/api/filters/products/names`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
  if (!res.ok) throw new Error('Failed to fetch product');
  return res.json();
}

export async function login() {
  const API_LOGIN = process.env.NEXT_PUBLIC_API_LOGIN;
  const API_PASSWORD = process.env.NEXT_PUBLIC_API_PASSWORD;

  const res = await fetch(`${API_URL}/api/login_check`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ username: API_LOGIN, password: API_PASSWORD }),
  });

  if (!res.ok) throw new Error('Login failed');

  const data = await res.json();
  localStorage.setItem('jwt', data.token);
  return data.token;
}
