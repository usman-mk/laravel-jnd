@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="container w-full px-4 py-3 bg-white rounded-lg shadow-md">
            <form method="POST" class="w-full mb-3" action="{{ route('short-url.short-url.store') }}">
                @csrf

                <div class="flex items-center py-2 mx-2 border-b border-teal-500">
                    <input
                        class="w-full px-2 py-1 mr-3 leading-tight text-gray-700 bg-transparent border-none appearance-none focus:outline-none"
                        type="text" name="original_url" id="original_url" placeholder="Paste a link to shorten" value="{{ old('original_url') }}">
                    <button
                        class="flex-shrink-0 px-2 py-1 text-sm text-white bg-teal-500 border-4 border-teal-500 rounded hover:bg-teal-700 hover:border-teal-700"
                        type="submit">
                        Shorten
                    </button>
                </div>
                @if ($errors->has('store'))
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                        {{ $errors->first() }}
                    </p>
                @endif

                <div class="flex flex-wrap mt-4 -mx-3">
                    <div class="w-1/2 px-2 mb-6 md:mb-0">
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="domain" id="domain"
                                class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " value="{{ route('short-url.short-url.redirect', '') }}/" readonly />
                            <label for="domain"
                                class="peer-focus:font-medium absolute px-2 text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                Domain
                            </label>
                        </div>
                    </div>
                    <div class="w-1/2 px-2">
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="code" id="code"
                                class="block py-2.5 px-2 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " />
                            <label for="code"
                                class="peer-focus:font-medium absolute px-2 text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                Enter a back-half
                            </label>
                        </div>
                    </div>
                </div>
            </form>

            @yield('sub-content')
        </div>
    </div>
@endsection
