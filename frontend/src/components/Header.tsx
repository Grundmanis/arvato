import React from 'react';
import Logo from '@/components/Logo';
import Link from 'next/link';

export default function Header({ children }: { children?: React.ReactNode }) {
  return (
    <header className="py-8">
      <div className="mx-auto flex flex-col items-center justify-between gap-4 px-4 sm:flex-row sm:gap-0 sm:px-0">
        <Link href="/">
          <Logo />
        </Link>
        <div className="flex items-center">{children}</div>
      </div>
    </header>
  );
}
