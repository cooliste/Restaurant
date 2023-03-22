<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=768">
  <link rel="icon" href="/storage/images/icon.png">
  <title>Import & Export Module - MPS</title>

  <link rel="stylesheet" href="{{ mix('css/port.css') }}">
</head>

<body>
  @php
    $routeName = request()
        ->route()
        ->getName();
  @endphp

  <div class="min-h-full">

    <div class="flex flex-col w-64 fixed inset-y-0 border-r border-gray-200 pt-5 pb-4 bg-gray-100">
      <div class="flex items-center flex-shrink-0 px-6">
        <img alt="" class="w-8 h-8 mr-3" src="/storage/images/icon.png">
        <div class="h-8 w-auto font-extrabold text-lg">Imports & Exports</div>
      </div>

      <div class="mt-6 h-0 flex-1 flex flex-col overflow-y-auto">

        <!-- Navigation -->
        <nav class="px-3 mt-6">
          <div class="space-y-1">
            <a href="{{ route('port') }}" @class([
                'group flex items-center px-2 py-2 text-sm font-medium rounded-md',
                'bg-gray-200 text-gray-900' => $routeName == 'port',
                'text-gray-700 hover:text-gray-900 hover:bg-gray-200' =>
                    $routeName != 'port',
            ]) aria-current="page">
              <svg class="text-gray-500 mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              {{ __('Home') }}
            </a>

            <a href="{{ route('categories.port') }}" @class([
                'group flex items-center px-2 py-2 text-sm font-medium rounded-md',
                'bg-gray-200 text-gray-900' => $routeName == 'categories.port',
                'text-gray-700 hover:text-gray-900 hover:bg-gray-200' =>
                    $routeName != 'categories.port',
            ])>
              <svg class="text-gray-500 mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
              </svg>
              {{ __('Categories') }}
            </a>

            <a href="{{ route('brands.port') }}" @class([
                'group flex items-center px-2 py-2 text-sm font-medium rounded-md',
                'bg-gray-200 text-gray-900' => $routeName == 'brands.port',
                'text-gray-700 hover:text-gray-900 hover:bg-gray-200' =>
                    $routeName != 'brands.port',
            ])>
              <svg class="text-gray-500 mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
              </svg>
              {{ __('Brands') }}
            </a>
          </div>
        </nav>
      </div>
    </div>

    <!-- Main column -->
    <div class="pl-64 flex flex-col">
      <main class="flex-1">
        <div class="border-b border-gray-200 px-6 py-3 sm:flex sm:items-center sm:justify-between">
          <div class="flex-1 min-w-0">
            <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">@yield('page_heading')</h1>
          </div>
          <div class="mt-4 flex sm:mt-0 sm:ml-4">
            <a href="/"
              class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-0">{{ __('Shop') }}</a>
            <a href="{{ route('mps') }}"
              class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3">{{ __('Admin') }}</a>
            <div class="flex items-center ml-3">
              <x-port::dropdown align="right" width="48" contentClasses="mt-4 py-1 bg-white">
                <x-slot name="trigger">
                  <button
                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                    <div>{{ Auth::user()->name }}</div>

                    <div class="ml-1">
                      <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd" />
                      </svg>
                    </div>
                  </button>
                </x-slot>

                <x-slot name="content">
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-port::dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                      {{ __('Log Out') }}
                    </x-port::dropdown-link>
                  </form>
                </x-slot>
              </x-port::dropdown>
            </div>
          </div>
        </div>

        <div class="px-6 py-4">
          @yield('content')
        </div>
      </main>
    </div>

    @if (session()->has('message'))
      <div x-data="{show: true}" aria-live="assertive"
        class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
        <div x-show="show" class="w-full flex flex-col items-center space-y-4 sm:items-end">
          <div x-show="show" x-transition
            class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="p-4">
              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                  <p class="text-sm font-medium text-gray-900">{{ __('Success!') }}</p>
                  <p class="mt-1 text-sm text-gray-500">{{ __(session('message')) }}</p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                  <button x-on:click="show = false"
                    class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                      aria-hidden="true">
                      <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif


    @if (session()->has('error'))
      <div x-data="{show: true}" aria-live="assertive"
        class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
        <div x-show="show" class="w-full flex flex-col items-center space-y-4 sm:items-end">
          <div x-show="show" x-transition
            class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="p-4">
              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                  <p class="text-sm font-medium text-gray-900">{{ __('Error!') }}</p>
                  <p class="mt-1 text-sm text-gray-500">{{ __(session('error')) }}</p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                  <button x-on:click="show = false"
                    class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                      aria-hidden="true">
                      <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif

    @if ($errors->any())
      <div x-data="{show: true}" aria-live="assertive"
        class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
        <div x-show="show" class="w-full flex flex-col items-center space-y-4 sm:items-end">
          <div x-show="show" x-transition
            class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="p-4">
              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                  @foreach ($errors->all() as $error)
                    <p class="mt-1 text-sm text-gray-500">
                      {{ __($error) }}
                    </p>
                  @endforeach
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                  <button x-on:click="show = false"
                    class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                      aria-hidden="true">
                      <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif

  </div>


  <script src="{{ mix('js/port.js') }}"></script>
  {{-- <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
</body>

</html>
