<div
    x-data="{ show: false, message: '', type: 'success' }"
    x-init="
        @if(session('success'))
            message = '{{ session('success') }}'; type = 'success'; show = true; setTimeout(() => show = false, 4000);
        @endif
        @if(session('error'))
            message = '{{ session('error') }}'; type = 'error'; show = true; setTimeout(() => show = false, 4000);
        @endif
         @if($errors->any())
            message = '{{ $errors->first() }}'; type = 'error'; show = true; setTimeout(() => show = false, 5000);
        @endif
    "
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    class="fixed bottom-5 left-1/2 z-100 w-full max-w-sm -translate-x-1/2 overflow-hidden rounded-xl border-l-4 bg-white shadow-lg ring-1 ring-black/5"
    :class="type === 'success' ? 'border-emerald-500' : 'border-red-500'"
    style="display: none"
>
    <div class="p-4">
        <div class="flex items-start">
            <div class="ml-3 w-0 flex-1">
                <p
                    class="text-sm font-bold text-gray-900"
                    x-text="type === 'success' ? 'Berhasil!' : 'Gagal!'"
                ></p>
                <p class="mt-1 text-sm text-gray-500" x-text="message"></p>
            </div>
            <button
                @click="show = false"
                class="ml-4 text-gray-400 hover:text-gray-500"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    </div>
</div>
