'use client';

import { useProductStore } from '@/providers/productProvider';
import { ListBulletIcon, Squares2X2Icon } from '@heroicons/react/20/solid';
import Button from './Button';

export default function TableGridSwitcher() {
  const { gridType, setGridType } = useProductStore((state) => state);
  return (
    <div className="inline-flex rounded-lg bg-white">
      <Button
        onClick={() => setGridType('table')}
        icon={<ListBulletIcon className="h-4 w-4" />}
        isActive={gridType === 'table'}
      >
        Table
      </Button>
      <Button
        onClick={() => setGridType('grid')}
        icon={<Squares2X2Icon className="h-4 w-4" />}
        isActive={gridType === 'grid'}
      >
        Grid
      </Button>
    </div>
  );
}
