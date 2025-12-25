'use client';

import { useReactTable, getCoreRowModel, flexRender, ColumnDef } from '@tanstack/react-table';
import { useRouter } from 'next/navigation';
import Checkbox from './Checkbox';
import { Product } from '@/types/product';

const columns: ColumnDef<Product>[] = [
  {
    id: 'select',
    cell: ({ row }) => (
      <Checkbox
        style="filled"
        isSelected={row.getIsSelected()}
        onChange={row.getToggleSelectedHandler()}
      />
    ),
  },
  {
    accessorKey: 'publicId',
    header: 'ID',
    cell: (info) => <span className="text-black">{`${info.getValue()}`}</span>,
  },
  {
    accessorKey: 'name',
    header: 'Name',
  },
  {
    accessorKey: 'category',
    header: 'Category',
  },
  {
    accessorKey: 'price',
    header: 'Price',
    cell: (info) => `$${info.getValue()}`,
  },
  {
    accessorKey: 'inStock',
    header: 'In Stock',
    cell: (info) => (info.getValue() ? 'True' : 'False'),
  },
  {
    accessorKey: 'quantity',
    header: 'Stock Quantity',
  },
  {
    accessorKey: 'rating',
    header: 'Rating',
  },
];

export default function ProductsTable({ products }: { products: Product[] }) {
  const router = useRouter();
  const table = useReactTable({
    data: products || [],
    columns,
    getCoreRowModel: getCoreRowModel(),
    enableRowSelection: true,
  });

  return (
    <div className="overflow-x-auto">
      <table className="divide-lightBorder text-grayish min-w-full divide-y text-sm">
        <thead className="bg-tableHead text-xs">
          {table.getHeaderGroups().map((headerGroup) => (
            <tr key={headerGroup.id}>
              {headerGroup.headers.map((header) => (
                <th key={header.id} className="font-third px-4 py-3 text-left font-normal">
                  {header.isPlaceholder
                    ? null
                    : flexRender(header.column.columnDef.header, header.getContext())}
                </th>
              ))}
            </tr>
          ))}
        </thead>
        <tbody className="divide-y divide-gray-200 bg-white">
          {table.getRowModel().rows.map((row) => (
            <tr
              onClick={() => router.push(`/product/${row.original.id}`)}
              key={row.id}
              className={`hover:bg-hover ${row.getIsSelected() ? 'bg-active' : ''}`}
            >
              {row.getVisibleCells().map((cell) => (
                <td className="px-4 py-3" key={cell.id}>
                  {flexRender(cell.column.columnDef.cell, cell.getContext())}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
