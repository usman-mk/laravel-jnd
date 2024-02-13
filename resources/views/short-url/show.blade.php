@extends('short-url.layouts.form')

@section('sub-content')
    <div
        class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Your orginal URL:</h5>
        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">{{ $model->original_url }}</p>
        <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Your shorten URL:</h5>
        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400" id="shorten-url">
            {{ route('short-url.short-url.redirect', $model->code) }}</p>
        <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
            <a href="{{ route('short-url.short-url.redirect', $model->code) }}" target="_blank"
                class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                <div class="text-left">
                    <div class="-mt-1 font-sans text-sm font-semibold">Open a new window</div>
                </div>
            </a>
            <button type="button" onclick="copyContent();" onmouseleave="defaultContent();" data-popover-target="popover-copy"
                data-popover-placement="bottom"
                class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                <div class="text-left">
                    <div class="-mt-1 font-sans text-sm font-semibold">Copy</div>
                </div>
            </button>
            <div data-popover id="popover-copy" role="tooltip"
                class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                <div class="px-3 py-2">
                    <p id="popover-copy-text">Copy to clipboard</p>
                </div>
                <div data-popper-arrow></div>
            </div>
        </div>
    </div>

    <script>
        const copyContent = async () => {
            try {
                let text = document.getElementById('shorten-url').innerHTML.replace(/^\s+|\s+$/gm, '');
                await navigator.clipboard.writeText(text);
                document.getElementById('popover-copy-text').innerHTML = `Copy success`;
            } catch (err) {
                console.error('Failed to copy: ', err);
            }
        }

        const defaultContent = () => {
            document.getElementById('popover-copy-text').innerHTML = `Copy to clipboard`;
        }
    </script>
@endsection
