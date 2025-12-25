export type ProductType = 'table' | 'grid';

export type Product = {
  id: number;
  name: string;
  category: string;
  price: number;
  inStock: boolean;
  quantity: number;
  publicId: string;
  createdAt: string;
  updatedAt: string;
  rating?: number;
};

export type ProductState = {
  gridType: ProductType;
  perPage: number;
  products: Product[];
  totalProductCount: number;
  currentProduct?: Product;
  loading: boolean;
  error: string | null;
};

export type ProductActions = {
  setGridType: (value: ProductType) => void;
  setPerPage: (value: number) => void;
  fetchProducts: (page: number, filters: Record<string, unknown>) => Promise<void>;
  fetchProductById: (id: number) => Promise<void>;
};

export type ProductStore = ProductState & ProductActions;

export const defaultInitState: ProductState = {
  gridType: 'table',
  perPage: 10,
  products: [],
  totalProductCount: 0,
  currentProduct: undefined,
  loading: false,
  error: null,
};
