@props ([
    "id",
    "action" => null,
    "method" => "POST",
    "title" => null,
    "type" => "info", // info, danger, success
    "confirmText" => "Ya, Lanjutkan"
])

@php
    $iconColor = [
        "info" => "bg-blue-500",
        "danger" => "bg-red-500",
        "success" => "bg-emerald-500",
    ][$type];

    $btnColor = [
        "info" => "bg-blue-600 hover:bg-blue-700",
        "danger" => "bg-red-600 hover:bg-red-700",
        "success" => "bg-emerald-600 hover:bg-emerald-700",
    ][$type];
@endphp

<div
    x-data="{ open: false }"
    x-show="open"
    @open-modal-{{ $id }}.window="open = true"
    @close-modal-{{ $id }}.window="open = false"
    class="relative z-50"
    style="display: none"
>
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity"
    ></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div
            class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
        >
            <div
                x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                @click.away="open = false"
            >
                <div class="p-6">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="{{ $iconColor }} mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full sm:mx-0 sm:h-10 sm:w-10"
                        >
                            @if ($type === "danger")
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                            @else
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                </svg>
                            @endif
                        </div>
                        <div
                            class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left"
                        >
                            <h3 class="text-xl font-bold text-gray-900">
                                {{ $title }}
                            </h3>
                            <div class="mt-2 text-sm text-gray-500">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col-reverse gap-2 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end"
                >
                    <button
                        type="button"
                        @click="open = false"
                        class="inline-flex justify-center rounded-xl px-4 py-2 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-200"
                    >
                        Batal
                    </button>

                    @if ($action)
                        <form
                            action="{{ $action }}"
                            method="POST"
                            class="m-0 p-0"
                        >
                            @csrf
                            @if (strtoupper($method) !== "POST")
                                @method ($method)
                            @endif
                            <button
                                type="submit"
                                class="inline-flex justify-center rounded-xl {{ $btnColor }} px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all"
                            >
                                {{ $confirmText }}
                            </button>
                        </form>
                    @else
                        <button
                            type="button"
                            id="confirm-button-{{ $id }}"
                            class="inline-flex justify-center rounded-xl {{ $btnColor }} px-5 py-2 text-sm font-semibold text-white shadow-sm transition-all"
                        >
                            {{ $confirmText }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
