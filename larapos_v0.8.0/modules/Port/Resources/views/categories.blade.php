@extends('port::layouts.port')
@section('page_heading')
  <div class="w-full flex items-center justify-between">
    {{ __('Categories') }}
    <form method="POST" action="{{ route('categories.export') }}">
      @csrf
      <a href="{{ route('categories.export') }}" onclick="event.preventDefault(); this.closest('form').submit();"
        class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-0">{{ __('Export') }}</a>
    </form>
  </div>
@endsection

@section('content')
  <div
    x-data="{ selected: null, loading: false, files: [], updateFile(e) { this.selected = e.target.files[0].name; }, init() { var fileInput = document.getElementById('file-upload'); var holder = document.getElementById('dropzone'); holder.ondragover = function () {  return false; }; holder.ondragend = function () {  return false; }; holder.ondrop = function (e) { e.preventDefault(); const dT = new DataTransfer(); dT.items.add(e.dataTransfer.files[0]); var fileExt = dT.files[0].name.split('.').pop(); if (fileExt == 'xls' || fileExt == 'xlsx') { fileInput.files = e.dataTransfer.files; if ('createEvent' in document) { var evt = document.createEvent('HTMLEvents'); evt.initEvent('change', false, true); fileInput.dispatchEvent(evt); } else { fileInput.fireEvent('onchange'); } } } }, }">
    <form id="iForm" method="post" action="{{ route('categories.import') }}" enctype="multipart/form-data">
      @csrf
      <p class="text-gray-600">{{ __('Please select the excel file to import categories.') }}</p>
      <div class="pt-5">
        <label for="file-upload"
          class="block text-sm rounded-md cursor-pointer focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
          <div id="dropzone" class="flex items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
            style="min-height:12rem">
            <div class="text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path
                  d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>

              <div class="flex items-center justify-center text-gray-700">
                <span class="relative bg-white font-medium text-indigo-600">
                  <span>{{ __('Upload a file') }}</span>
                  <input ref="file" type="file" class="sr-only" id="file-upload" name="file" x-on:change="updateFile"
                    accept=".xls,.xlsx,application/vnd.ms-excel" />
                </span>
                <p class="pl-1">{{ __('or drag and drop') }}</p>
              </div>
              <div class="text-gray-700">
                <div>{{ __('Excel file should have name, code, parent & photo columns and size up to 2MB.') }}</div>
                <div>{{ __('You must fill the name and code columns.') }} {{ __('parent is the code of the parent category.') }}
                  {{ __('photo should be the path to the image in public folder.') }}</div>
              </div>
              <div x-show="selected" class="inline-block text-indigo-600 pt-4 mt-6">
                <div class="flex items-center justify-center px-3 py-1 rounded-md border border-indigo-600 font-bold text-lg">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-green-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="font-extrabold" x-html="selected"></span>
                </div>
              </div>
            </div>
          </div>
        </label>
      </div>
      <div x-show="selected" class="pt-5">
        <div class="flex justify-start">
          <button type="submit" x-on:click="loading = true; document.getElementById('iForm').submit();" x-bind:disabled="loading"
            class="relative w-full flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-75 disabled:bg-indigo-400">
            Import
            <svg x-show="loading" class="w-6 h-6 ml-3" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg" stroke="#fff">
              <g fill="none" fill-rule="evenodd">
                <g transform="translate(1 1)" stroke-width="2">
                  <circle stroke-opacity=".5" cx="18" cy="18" r="18" />
                  <path d="M36 18c0-9.94-8.06-18-18-18">
                    <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s"
                      repeatCount="indefinite" />
                  </path>
                </g>
              </g>
            </svg>
          </button>
        </div>
      </div>
    </form>
  </div>
@endsection
