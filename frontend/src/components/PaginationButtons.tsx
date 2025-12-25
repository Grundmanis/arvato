'use client';

import React from 'react';

type PaginationProps = {
  currentPage: number;
  totalItems: number;
  perPage: number;
  onPageChange: (page: number) => void;
};

const PaginationButtons: React.FC<PaginationProps> = ({
  currentPage,
  totalItems,
  perPage,
  onPageChange,
}) => {
  if (totalItems < perPage) return null;
  const totalPages = Math.ceil(totalItems / perPage);

  const pageNumbers: number[] = [];
  const maxVisible = 5;

  let startPage = Math.max(1, currentPage - 2);
  const endPage = Math.min(totalPages, startPage + maxVisible - 1);

  if (endPage - startPage + 1 < maxVisible) {
    startPage = Math.max(1, endPage - maxVisible + 1);
  }

  for (let i = startPage; i <= endPage; i++) {
    pageNumbers.push(i);
  }

  const showDots = endPage < totalPages;

  return (
    <div className="flex items-center justify-center gap-2 text-lg">
      <button
        onClick={() => onPageChange(Math.max(1, currentPage - 1))}
        disabled={currentPage === 1}
        className="border-grayishTwo text-grayish hover:bg-main/10 hover:border-main h-8 w-8 cursor-pointer rounded border bg-white disabled:opacity-50"
      >
        ◀
      </button>

      <span className="border-grayishTwo flex h-8 w-8 items-center justify-center rounded border bg-white md:hidden">
        {currentPage}
      </span>

      <div className="hidden items-center gap-2 md:flex">
        {pageNumbers.map((page) => (
          <button
            key={page}
            onClick={() => onPageChange(page)}
            className={`border-grayishTwo hover:border-main hover:bg-main/10 h-8 w-8 cursor-pointer rounded border bg-white ${
              page === currentPage ? 'bg-main! border-main text-white' : ''
            }`}
          >
            {page}
          </button>
        ))}

        {showDots && (
          <>
            <span className="flex h-8 items-end justify-center">...</span>
            <button
              onClick={() => onPageChange(totalPages)}
              className={`border-grayishTwo hover:border-main hover:bg-main/10 h-8 w-8 cursor-pointer rounded border bg-white ${
                currentPage === totalPages ? 'bg-blue-500 text-white' : ''
              }`}
            >
              {totalPages}
            </button>
          </>
        )}
      </div>

      <button
        onClick={() => onPageChange(Math.min(totalPages, currentPage + 1))}
        disabled={currentPage === totalPages}
        className="border-grayishTwo text-grayish hover:border-main hover:bg-main/10 h-8 w-8 cursor-pointer rounded border bg-white disabled:opacity-50"
      >
        ▶
      </button>
    </div>
  );
};

export default PaginationButtons;
