import Image from 'next/image';

export default function Logo() {
  return <Image src="/logo.png" alt="Arvato" width={249} height={94} priority className="h-auto" />;
}
