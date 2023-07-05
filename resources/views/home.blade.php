@extends('layout.app')
@section('content')
<div class="overflow-hidden">
  <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="relative mx-auto max-w-4xl grid space-y-5 sm:space-y-10">
      <div class="text-center">
        <h1 class="text-3xl font-bold sm:text-5xl lg:text-6xl lg:leading-tight">
          Turn online shoppers into <span class="text-blue-500">lifetime customers</span>
        </h1>
      </div>
      <form method="get" action="{{ route(session('language').'.emlaklistesi') }}">
        <div class="mx-auto max-w-4xl sm:flex sm:space-x-3 p-3 bg-white  rounded-lg shadow-lg shadow-gray-100 dark:bg-slate-900 dark:shadow-gray-900/[.2]">
          <div class="pb-2 sm:pb-0 sm:flex-[1_0_0%]">
            <select
              name="post_type"
              class="py-3 px-2 pr-9 block w-full border border-gray-100 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
              <option selected>{{ __('form.tumu') }}</option>
              <option value="for_sale">{{ __('form.satilik') }}</option>
              <option value="for_rent">{{ __('form.kiralik') }}</option>
            </select>
          </div>
          <div class="pt-2 sm:pt-0 sm:pl-3 sm:flex-[1_0_0%]">
            <select 
              name="type"
              class="py-3 px-2 pr-9 block w-full border border-gray-100 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
              <option selected>{{ __('form.emlaktipi') }}</option>
              @foreach($emlakgruplari as $et)
              <option value="{{ $et->id }}">{{ __('emlakgrubu.'.$et->id) }}</option>
              @endforeach
            </select>
          </div>
          <div class="pt-2 sm:pt-0 sm:pl-3 sm:flex-[1_0_0%]">
            <select
              name="city"
              class="py-3 px-2 pr-9 block w-full border border-gray-100 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
              <option selected>{{ __('form.il') }}</option>
              @foreach($iller as $il)
              <option value="{{ $il->id }}">{{ __('iller.'.$il->id) }}</option>
              @endforeach
            </select>
          </div>
          <div class="pt-2 sm:pt-0 grid sm:block sm:flex-[0_0_auto]">
            <a class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm sm:p-4 dark:focus:ring-offset-gray-800" href="#">
              {{ __('form.ara') }}
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection