'use client';

import Breadcrumbs from '@/components/Breadcrumbs';
import ProductClient from './ProductClient';
import { useParams } from 'next/navigation';

export default function Home() {
  const params = useParams();
  const productId = params?.id;

  return (
    <div className="">
      <Breadcrumbs />
      <ProductClient productId={productId as string} />
    </div>
  );
}
