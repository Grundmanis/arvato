import type { NextConfig } from 'next';

console.log('test', (process.env.NEXT_PUBLIC_API_URL || '').replace(/^https?:\/\//, ''));

const nextConfig: NextConfig = {
  /* config options here */
  reactCompiler: true,
  images: {
    remotePatterns: [
      {
        protocol: 'http',
        hostname: 'arvato.lndo.site',
        port: '',
        pathname: '/uploads/products/**',
      },
    ],
  },
};

export default nextConfig;
