import React from 'react';
import { Button as HeadlessButton } from '@headlessui/react';

type ButtonProps = React.ButtonHTMLAttributes<HTMLButtonElement> & {
  icon?: React.ReactNode;
  isActive?: boolean;
};

export default function Button({
  children,
  icon,
  isActive = false,
  className = '',
  ...props
}: ButtonProps) {
  return (
    <HeadlessButton
      className={`flex cursor-pointer items-center gap-2 rounded-xl px-5 py-3 font-medium ${isActive ? 'bg-main text-white' : 'bg-white text-black'} ${className}`}
      {...props}
    >
      {icon && <span>{icon}</span>}
      {children}
    </HeadlessButton>
  );
}
