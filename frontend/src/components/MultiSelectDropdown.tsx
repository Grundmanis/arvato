'use client';

import { Fragment } from 'react';
import {
  Listbox,
  ListboxButton,
  ListboxOption,
  ListboxOptions,
  Transition,
} from '@headlessui/react';
import Checkbox from './Checkbox';

type Option = {
  label: string;
  value: string | number;
};

type MultiSelectDropdownProps = {
  options: Option[];
  selected: Option[];
  onChange: (selected: Option[]) => void;
  placeholder?: string;
};

export default function MultiSelectDropdown({
  options,
  selected,
  onChange,
  placeholder = 'Select...',
}: MultiSelectDropdownProps) {
  const toggleOption = (option: Option) => {
    if (selected.find((o) => o.value === option.value)) {
      onChange(selected.filter((o) => o.value !== option.value));
    } else {
      onChange([...selected, option]);
    }
  };

  return (
    <Listbox as="div" className="relative min-w-[166px]" value={selected} onChange={() => {}}>
      <ListboxButton className="bg-main hover:bg-mainLighter flex w-full cursor-pointer items-center justify-between rounded-xl border px-4 py-2 text-left text-lg text-white">
        <span>{placeholder}</span>
        <span className="font-secondary ml-2">▾</span>
      </ListboxButton>

      <Transition
        as={Fragment}
        enter="transition ease-out duration-150"
        enterFrom="opacity-0 translate-y-1"
        enterTo="opacity-100 translate-y-0"
        leave="transition ease-in duration-100"
        leaveFrom="opacity-100 translate-y-0"
        leaveTo="opacity-0 translate-y-1"
      >
        <ListboxOptions className="ring-opacity-5 absolute z-10 mt-1 max-h-44 w-full overflow-auto rounded-lg bg-white py-1 text-base shadow-lg focus:outline-none sm:text-sm">
          {options.map((option) => {
            const isSelected = selected.find((o) => o.value === option.value);
            return (
              <ListboxOption key={option.value} as={Fragment} value={option}>
                <li
                  onClick={(e) => {
                    e.preventDefault();
                    toggleOption(option);
                  }}
                  className={`hover:bg-hover flex cursor-pointer items-center px-4 py-2`}
                >
                  <Checkbox
                    style="outline"
                    isSelected={!!isSelected}
                    option={option}
                    onChange={() => toggleOption(option)}
                  />
                </li>
              </ListboxOption>
            );
          })}
        </ListboxOptions>
      </Transition>
    </Listbox>
  );
}
