import ElementWrapper from '@/components/ElementWrapper';
import Header from '@/components/Header';
import TableGridSwitcher from '@/components/TableGridSwitcher';

export default function PublicLayout({ children }: { children: React.ReactNode }) {
  return (
    <div className="flex min-h-screen flex-col">
      <Header>
        <ElementWrapper>
          <TableGridSwitcher />
        </ElementWrapper>
      </Header>
      <main className="mx-auto w-full flex-1 px-4 py-9 sm:px-0">{children}</main>
    </div>
  );
}
