@props([
    'label' => '',
    'rows' => 3,
])

<div class="flex flex-col space-y-1 w-full">
    @if ($label)
        <label class="text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif

    <textarea
        rows="{{ $rows }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none'
        ]) }}
    ></textarea>

    @error($attributes->wire('model')->value())
        <span class="text-red-500 text-xs">{{ $message }}</span>
    @enderror
</div>
