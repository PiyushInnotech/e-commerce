@props(['name', 'label', 'value' => '', 'required' => false, 'id' => null])

@php
    $id = $id ?? $name;
@endphp

<div class="mb-4">
    @if($label ?? null)
        <label for="{{ $id }}" class="font-medium 3xl:text-xl 3xl:font-semibold">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        <input
            type="password"
            name="{{ $name }}"
            id="{{ $id }}"
            value="{{ old($name, $value) }}"
            {{ $attributes->merge(['class' => 'appearance-none rounded-md relative block w-full px-3 mt-2 3xl:mt-3 py-2 3xl:py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm 3xl:text-lg pr-10']) }}
        >

        <button
            type="button"
            class="absolute z-50 inset-y-0 right-0 flex items-center px-3 text-gray-600 hover:text-gray-800 focus:outline-none cursor-pointer"
            onclick="togglePasswordVisibility('{{ $id }}', this)"
            aria-label="Toggle password visibility"
        >
            <svg id="{{ $id }}-eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg id="{{ $id }}-eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            </svg>
        </button>
    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<script>
    function togglePasswordVisibility(inputId, button) {
        const input = document.getElementById(inputId);
        const eyeIcon = document.getElementById(`${inputId}-eye-icon`);
        const eyeSlashIcon = document.getElementById(`${inputId}-eye-slash-icon`);
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        }
    }
</script>