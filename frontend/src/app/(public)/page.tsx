'use client';

import PaginationButtons from '@/components/PaginationButtons';
import MultiSelectDropdown from '@/components/MultiSelectDropdown';
import ProductsTable from '@/components/ProductsTable';
import Dropdown from '@/components/Dropdown';
import ElementWrapper from '@/components/ElementWrapper';
import ProductGrid from '@/components/ProductsGrid';
import { useProductStore } from '@/providers/productProvider';
import Loading from '@/components/Loading';
import { perPages } from '@/constants/product';
import { useProductsFetcher } from '@/hooks/useProductFetcher';
import { useProductFilters } from '@/hooks/useProductFilters';
import { usePagination } from '@/hooks/usePagination';

export default function Home() {
  const {
    gridType,
    perPage,
    setPerPage,
    fetchProducts,
    products,
    totalProductCount,
    loading,
    sort,
    setSort,
  } = useProductStore((state) => state);

  const {
    selectedCategories,
    setSelectedCategories,
    selectedName,
    setSelectedName,
    categoryOptions,
    nameOptions,
    clearFilters,
  } = useProductFilters();

  const { page, setPage } = usePagination();

  useProductsFetcher(
    fetchProducts,
    setPage,
    page,
    { name: selectedName, category: selectedCategories },
    perPage,
    sort,
  );

  return (
    <div className="flex min-h-[calc(100vh-310px)] flex-col">
      <ElementWrapper className="flex flex-col items-center gap-3 p-3 sm:flex-row">
        <div className="flex flex-col flex-wrap items-center gap-2 sm:flex-row">
          <Dropdown
            placeholder={selectedName || 'Name'}
            options={nameOptions}
            onSelect={(value) => setSelectedName(value as string)}
          />
          <MultiSelectDropdown
            options={categoryOptions}
            selected={selectedCategories}
            onChange={(value) => setSelectedCategories(value as { label: string; value: string }[])}
            placeholder="Category"
          />
          <div className="text-main capitalize">
            {selectedCategories.length > 0 && (
              <span>{selectedCategories.map((o) => o.label).join(', ')}</span>
            )}
          </div>
        </div>
        <div className="sm:ml-auto">
          <button
            className="cursor-pointer text-lg font-semibold capitalize underline"
            onClick={clearFilters}
          >
            Clear filters
          </button>
        </div>
      </ElementWrapper>

      <div className="mt-7 flex-1">
        {loading ? (
          <Loading />
        ) : products.length === 0 ? (
          <div className="py-10 text-center text-gray-500">No products found.</div>
        ) : gridType === 'table' ? (
          <ProductsTable products={products} onSortingChange={setSort} sortingData={sort} />
        ) : (
          <ProductGrid products={products} />
        )}
      </div>

      <div className="mt-5 flex justify-center">
        <PaginationButtons
          currentPage={page}
          totalItems={totalProductCount}
          perPage={perPage}
          onPageChange={setPage}
        />
        <Dropdown
          options={perPages}
          size="small"
          onSelect={(value) => setPerPage(Number(value))}
          placeholder={`${perPage} per page`}
          className="ml-2"
        />
      </div>
    </div>
  );
}
