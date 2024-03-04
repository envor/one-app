@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['rows' => '5', 'class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600']) !!}>{{ isset($attributes['value']) ? $attributes['value'] : $slot }}</textarea>