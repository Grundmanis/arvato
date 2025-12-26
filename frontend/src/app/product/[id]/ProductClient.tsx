'use client';

import Loading from '@/components/Loading';
import { useProductStore } from '@/providers/productProvider';
import Image from 'next/image';
import { useEffect } from 'react';

type Props = {
  productId: string;
};
export default function ProductClient({ productId }: Props) {
  const { fetchProductById, currentProduct } = useProductStore((state) => state);

  useEffect(() => {
    const id = Number(productId);
    if (!isNaN(id)) {
      fetchProductById(id);
    }
  }, [productId, fetchProductById]);

  return (
    <div className="mt-2">
      <h1 className="text-[28px] font-bold">Product details</h1>

      {!currentProduct ? (
        <Loading />
      ) : (
        <div className="mt-2 flex max-w-6xl flex-col rounded-lg bg-white p-1 text-[22px] shadow-lg md:flex-row">
          <div className="h-60 w-full md:h-auto md:w-1/2">
            <Image
              className="m-1 rounded-lg"
              alt="cpu"
              width="540"
              height="200"
              src={currentProduct.images[0].url}
              unoptimized
            />
          </div>

          <div className="flex w-full flex-col justify-start p-4 px-6 md:w-1/2">
            <div className="mb-4">ID: {currentProduct?.publicId}</div>
            <div className="space-y-1 text-gray-500">
              <div className="py-1">Name: {currentProduct?.name}</div>
              <div className="py-1">Category: {currentProduct?.category}</div>
              <div className="py-1">Price: {currentProduct?.price}</div>
              <div className="py-1">In Stock: {currentProduct?.inStock ? 'Yes' : 'No'}</div>
              <div className="py-1">Stock Quantity: {currentProduct?.quantity}</div>
              <div className="py-1">Rating: {currentProduct?.rating}</div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
