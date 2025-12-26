'use client';

import { useRouter } from 'next/navigation';
import Image from 'next/image';
import { Product } from '@/types/product';

export default function ProductGrid({ products }: { products: Product[] }) {
  const router = useRouter();

  return (
    <div className="grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-4">
      {products.map((product) => (
        <div
          key={product.id}
          onClick={() => router.push(`/product/${product.id}`)}
          className="flex cursor-pointer flex-col rounded-lg bg-white p-1 shadow-2xs"
        >
          <div className="h-48 w-full overflow-hidden rounded-lg">
            <Image
              src={product.images[0].url}
              alt="cpu"
              width={300}
              height={200}
              className="h-full w-full object-cover"
              unoptimized
            />
          </div>

          <div className="p-4">
            <div>ID: {product.publicId}</div>
            <div className="text-gray-500">
              <div>Price: ${product.price}</div>
              <div>Stock Quantity: {product.quantity}</div>
            </div>
          </div>
        </div>
      ))}
    </div>
  );
}
