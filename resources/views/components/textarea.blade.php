<!-- filepath: d:\Dev\rhesa\resources\views\components\textarea.blade.php -->
<div class="mb-4">
    <label class="block mb-1 text-sm font-medium">{{ $label }}</label>
    <textarea
        {{ $attributes }}
        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
        rows="{{ $rows ?? 3 }}"
    ></textarea>
    @error($attributes->wire('model')->value)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>