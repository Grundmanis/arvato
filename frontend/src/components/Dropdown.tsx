import { Menu, MenuButton, MenuItem, MenuItems, Transition } from '@headlessui/react';
import { Fragment } from 'react/jsx-runtime';

type Option = {
  label: string;
  value: string | number;
};

type Size = 'default' | 'small' | undefined;

type DropdownProps = {
  options: Option[];
  size?: Size;
  onSelect?: (value: string | number) => void;
  placeholder: string;
  className?: string;
};

export default function Dropdown({
  placeholder,
  options,
  onSelect,
  size,
  className,
}: DropdownProps) {
  return (
    <Menu>
      {({ open }) => (
        <div className="relative inline-block">
          <MenuButton
            className={`text-dark hover:border-main inline-flex w-full min-w-[141px] cursor-pointer items-center justify-between rounded-xl border bg-white px-4 py-2 text-lg capitalize ${
              open ? 'border-main' : 'border-dark'
            } ${size == 'small' ? 'border-grayishTwo h-8 !rounded-lg' : ''} ${className}`}
          >
            <span className="truncate">{placeholder}</span>
            <span className="font-secondary ml-2">▾</span>
          </MenuButton>

          <Transition
            as={Fragment}
            enter="transition ease-out duration-150"
            enterFrom="opacity-0 translate-y-1"
            enterTo="opacity-100 translate-y-0"
            leave="transition ease-in duration-100"
            leaveFrom="opacity-100 translate-y-0"
            leaveTo="opacity-0 translate-y-1"
          >
            <MenuItems
              anchor="bottom end"
              className="ring-opacity-5 text-grayish absolute z-10 mt-1 !max-h-44 w-[var(--button-width)] origin-top-right !overflow-x-hidden rounded-lg bg-white p-1 text-sm/6 shadow-lg transition duration-100 ease-out [--anchor-gap:--spacing(1)] focus:outline-none data-closed:scale-95 data-closed:opacity-0"
            >
              {options.map((option) => (
                <MenuItem key={option.value}>
                  <button
                    onClick={() => {
                      onSelect?.(option.value);
                    }}
                    className="data-focus:bg-blue-10 hover:bg-hover block w-full cursor-pointer rounded-md px-1 py-1 text-left capitalize"
                  >
                    {option.label}
                  </button>
                </MenuItem>
              ))}
            </MenuItems>
          </Transition>
        </div>
      )}
    </Menu>
  );
}
