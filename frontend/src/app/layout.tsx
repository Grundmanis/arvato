import type { Metadata } from 'next';
import './globals.css';
import { ProductStoreProvider } from '@/providers/productProvider';

export const metadata: Metadata = {
  title: 'Arvato',
  description: 'Task',
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <ProductStoreProvider>
        <body className="min-h-screen bg-gray-50 px-[46px]">{children}</body>
      </ProductStoreProvider>
    </html>
  );
}
