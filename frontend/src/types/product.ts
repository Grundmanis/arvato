export type ProductType = 'table' | 'grid';
type ProductImage = {
  id: number;
  path: string;
  url: string;
};

export type Sort = {
  id: string;
  desc: boolean;
};

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
  images: ProductImage[];
};

export type ProductState = {
  gridType: ProductType;
  perPage: number;
  products: Product[];
  totalProductCount: number;
  sort: Sort[];
  currentProduct?: Product;
  loading: boolean;
  error: string | null;
};

export type ProductActions = {
  setGridType: (value: ProductType) => void;
  setPerPage: (value: number) => void;
  fetchProducts: (page: number, filters: Record<string, unknown>, sort?: Sort[]) => Promise<void>;
  fetchProductById: (id: number) => Promise<void>;
  setSort: (value: Sort[]) => void;
};

export type ProductStore = ProductState & ProductActions;

export const defaultInitState: ProductState = {
  gridType: 'table',
  perPage: 10,
  products: [],
  totalProductCount: 0,
  sort: [],
  currentProduct: undefined,
  loading: false,
  error: null,
};
