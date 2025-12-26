import Breadcrumbs from '@/components/Breadcrumbs';
import ProductClient from './ProductClient';

type Props = {
  params: {
    id: string;
  };
};

export default function Home({ params }: Props) {
  return (
    <div className="">
      <Breadcrumbs />
      <ProductClient productId={params.id as string} />
    </div>
  );
}

export async function generateStaticParams() {
  return [{ id: '1' }, { id: '2' }, { id: '3' }];
}
