'use client';

import {
  useReactTable,
  getCoreRowModel,
  flexRender,
  ColumnDef,
  getSortedRowModel,
} from '@tanstack/react-table';
import { useRouter } from 'next/navigation';
import Checkbox from './Checkbox';
import { Product, Sort } from '@/types/product';
import { useEffect, useState } from 'react';

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
    enableSorting: true,
    header: ({ column }) => (
      <button
        onClick={column.getToggleSortingHandler()}
        className="flex cursor-pointer items-center gap-1"
      >
        ID
        {column.getIsSorted() === 'asc' && '↑'}
        {column.getIsSorted() === 'desc' && '↓'}
      </button>
    ),
    cell: (info) => <span className="text-black">{`${info.getValue()}`}</span>,
  },
  {
    accessorKey: 'name',
    header: ({ column }) => (
      <button
        onClick={column.getToggleSortingHandler()}
        className="flex cursor-pointer items-center gap-1"
      >
        Name
        {column.getIsSorted() === 'asc' && '↑'}
        {column.getIsSorted() === 'desc' && '↓'}
      </button>
    ),
  },
  {
    accessorKey: 'category',

    header: ({ column }) => (
      <button
        onClick={column.getToggleSortingHandler()}
        className="flex cursor-pointer items-center gap-1"
      >
        Category
        {column.getIsSorted() === 'asc' && '↑'}
        {column.getIsSorted() === 'desc' && '↓'}
      </button>
    ),
  },
  {
    accessorKey: 'price',
    header: ({ column }) => (
      <button
        onClick={column.getToggleSortingHandler()}
        className="flex cursor-pointer items-center gap-1"
      >
        Price
        {column.getIsSorted() === 'asc' && '↑'}
        {column.getIsSorted() === 'desc' && '↓'}
      </button>
    ),
    cell: (info) => `$${info.getValue()}`,
  },
  {
    accessorKey: 'inStock',
    header: ({ column }) => (
      <button
        onClick={column.getToggleSortingHandler()}
        className="flex cursor-pointer items-center gap-1"
      >
        In Stock
        {column.getIsSorted() === 'asc' && '↑'}
        {column.getIsSorted() === 'desc' && '↓'}
      </button>
    ),
    cell: (info) => (info.getValue() ? 'True' : 'False'),
  },
  {
    accessorKey: 'quantity',
    header: ({ column }) => (
      <button
        onClick={column.getToggleSortingHandler()}
        className="flex cursor-pointer items-center gap-1"
      >
        Stock Quantity
        {column.getIsSorted() === 'asc' && '↑'}
        {column.getIsSorted() === 'desc' && '↓'}
      </button>
    ),
  },
  {
    accessorKey: 'rating',
    header: ({ column }) => (
      <button
        onClick={column.getToggleSortingHandler()}
        className="flex cursor-pointer items-center gap-1"
      >
        Rating
        {column.getIsSorted() === 'asc' && '↑'}
        {column.getIsSorted() === 'desc' && '↓'}
      </button>
    ),
  },
];

export default function ProductsTable({
  products,
  onSortingChange,
  sortingData,
}: {
  products: Product[];
  onSortingChange: (value: { id: string; desc: boolean }[]) => void;
  sortingData: Sort[];
}) {
  const [sorting, setSorting] = useState(sortingData);
  const router = useRouter();
  const table = useReactTable({
    data: products || [],
    columns,
    state: {
      sorting,
    },
    onSortingChange: setSorting,
    getCoreRowModel: getCoreRowModel(),
    enableRowSelection: true,
    manualSorting: true,
    getSortedRowModel: getSortedRowModel(),
  });

  useEffect(() => {
    onSortingChange(sorting);
  }, [sorting]);

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
