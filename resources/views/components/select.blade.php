<div class="mb-4">
    <label class="block mb-1 text-sm font-semibold text-[#12458f]">{{ $label }}</label>
    <select {{ $attributes }} class="w-full border border-[#9bb8e6] rounded-lg px-3 py-2 bg-white text-gray-800 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-[#12458f] focus:border-[#12458f]">
        {{ $slot }}
    </select>
    @error($attributes->wire('model')->value)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>