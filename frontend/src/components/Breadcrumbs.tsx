import { useRouter } from 'next/navigation';

export default function Breadcrumbs() {
  const router = useRouter();
  return (
    <div className="flex">
      <button
        className="text-grayish flex cursor-pointer items-center gap-2 text-xl"
        onClick={() => router.back()}
      >
        <span className="">◀</span>
        <span>Back</span>
      </button>
    </div>
  );
}
