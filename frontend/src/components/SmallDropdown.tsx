import { Menu, MenuButton, MenuItem, MenuItems, Transition } from '@headlessui/react';
import { Fragment } from 'react/jsx-runtime';

type Option = {
  label: string;
  value: string | number;
};

type DropdownProps = {
  options: Option[];
  style?: 'default|small';
  onSelect?: (value: string | number) => void;
  selected?: string | number;
  placeholder: string;
};

export default function SmallDropdown({ placeholder, options, onSelect, selected }: DropdownProps) {
  return (
    <Menu>
      {({ open }) => (
        <div className="relative inline-block">
          <MenuButton
            className={`text-dark hover:border-main inline-flex w-full min-w-[141px] items-center justify-between rounded-lg border px-4 py-2 capitalize ${
              open ? 'border-main' : 'border-dark'
            }`}
          >
            <span className="truncate">{selected || placeholder}</span>
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
                    className="data-focus:bg-blue-10 hover:bg-hover block w-full rounded-md px-1 py-1 text-left capitalize"
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
