@props ([
    "action",
    "trigger" => null,
    "triggerAttributes" => null,
    "title" => "Tambah Data",
    "method" => "POST"
])

<div x-data="{ openModal: false }">
    <button
        @click="openModal = true"
        class="{{ $triggerAttributes ?? 'bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-sm shadow-sm' }}"
    >
        {{
            $trigger ??
                "+ Tambah Data"
        }}
    </button>

    <div
        x-show="openModal"
        class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto"
        x-cloak
    >
        <div
            class="fixed inset-0 bg-black/20 transition-opacity"
            @click="openModal = false"
        ></div>

        <div
            class="z-10 m-4 transform overflow-hidden rounded-lg bg-white shadow-xl transition-all sm:w-full sm:max-w-lg"
        >
            <div
                class="flex items-center justify-between border-b border-gray-200 bg-gray-100 px-4 py-3"
            >
                <h3 class="text-lg font-semibold text-gray-800">
                    {{ $title }}
                </h3>
                <button
                    @click="openModal = false"
                    class="text-xl font-bold text-gray-400 hover:text-gray-600"
                >
                    &times;
                </button>
            </div>

            <form
                action="{{ $action }}"
                method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}"
            >
                @csrf
                @if (!in_array(strtoupper($method), ["GET", "POST"]))
                    @method ($method)
                @endif

                <div class="space-y-4 px-6 py-4">{{ $slot }}</div>

                <div
                    class="flex justify-end space-x-2 border-t border-gray-200 bg-gray-50 px-6 py-3"
                >
                    <button
                        type="button"
                        @click="openModal = false"
                        class="rounded-sm bg-gray-300 px-4 py-2 font-semibold text-gray-800 shadow-sm hover:bg-gray-400"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="rounded-sm bg-blue-600 px-4 py-2 font-semibold text-white shadow-sm hover:bg-blue-700"
                    >
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
