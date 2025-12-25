import React from 'react';

type ElementWrapperProps = {
  children: React.ReactNode;
  className?: string;
};

export default function ElementWrapper({ children, className }: ElementWrapperProps) {
  return <div className={`rounded-lg bg-white p-2 ${className}`}>{children}</div>;
}
