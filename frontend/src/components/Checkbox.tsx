import { Checkbox as HeadlessCheckbox } from '@headlessui/react';

export default function Checkbox({
  isSelected,
  option,
  onChange,
  style,
}: {
  isSelected: boolean;
  option?: { label: string };
  onChange?: (event?: unknown) => void;
  style: 'filled' | 'outline';
}) {
  const outlineClassNames = 'data-checked:bg-white ';
  const filledClassNames = 'data-checked:bg-main';
  return (
    <div className="flex cursor-pointer items-center justify-center">
      <HeadlessCheckbox
        checked={isSelected}
        onClick={(e) => e.stopPropagation()}
        onChange={onChange}
        className={`group border-checkboxBorder data-checked:border-main h-5 w-5 rounded border bg-white ${style === 'filled' ? filledClassNames : outlineClassNames}`}
      >
        {style === 'outline' && (
          <svg
            className="stroke-main opacity-0 group-data-checked:opacity-100"
            viewBox="0 0 14 14"
            fill="none"
          >
            <path
              d="M3 8L6 11L11 3.5"
              strokeWidth={2}
              strokeLinecap="round"
              strokeLinejoin="round"
            />
          </svg>
        )}
      </HeadlessCheckbox>
      <span onClick={onChange} className={'text-grayish ml-2 capitalize'}>
        {option?.label}
      </span>
    </div>
  );
}
