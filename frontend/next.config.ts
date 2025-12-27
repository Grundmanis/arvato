import type { NextConfig } from 'next';

const nextConfig: NextConfig = {
  /* config options here */
  reactCompiler: true,

  images: {
    unoptimized: true,
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
