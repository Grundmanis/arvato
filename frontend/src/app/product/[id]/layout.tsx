import Header from '@/components/Header';

export default function PublicLayout({ children }: { children: React.ReactNode }) {
  return (
    <div className="flex min-h-screen flex-col">
      <Header />
      <main className="mx-auto w-full flex-1 py-4">{children}</main>
    </div>
  );
}
