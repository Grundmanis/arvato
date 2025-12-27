import { fetchProductCategories, fetchProductNames } from '@/lib/api/products.api';
import { useState, useEffect } from 'react';

export function useProductFilters() {
  const [categories, setCategories] = useState<string[]>([]);
  const [names, setNames] = useState<string[]>([]);
  const [selectedCategories, setSelectedCategories] = useState<{ label: string; value: string }[]>(
    [],
  );
  const [selectedName, setSelectedName] = useState<string>();

  useEffect(() => {
    fetchProductCategories().then(setCategories);
    fetchProductNames().then(setNames);
  }, []);

  const categoryOptions = categories.map((item) => ({ label: item, value: item.toLowerCase() }));
  const nameOptions = names.map((item) => ({ label: item, value: item.toLowerCase() }));

  const clearFilters = () => {
    setSelectedCategories([]);
    setSelectedName(undefined);
  };

  return {
    selectedCategories,
    setSelectedCategories,
    selectedName,
    setSelectedName,
    categoryOptions,
    nameOptions,
    clearFilters,
  };
}
