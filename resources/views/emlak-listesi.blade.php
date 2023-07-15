@extends('layout.app')
@section('content')
<section>
  <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <header>
      <h2 class="text-xl font-bold text-gray-900  dark:text-gray-400 sm:text-3xl">
        Product Collection
      </h2>
      <p class="mt-4 max-w-md text-gray-500">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque
        praesentium cumque iure dicta incidunt est ipsam, officia dolor fugit
        natus?
      </p>
    </header>
    <div class="mt-8 block lg:hidden">
      <!-- Modal gelmesi gerekiyor... -->
      <button class="flex cursor-pointer items-center gap-2 border-b border-gray-400 pb-1 text-gray-900  dark:text-gray-400 transition hover:border-gray-600">
        <span class="text-sm font-medium"> {{ __('site.filtreler_ve_siralama') }} </span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 rtl:rotate-180">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
      </button>
    </div>

    <div class="mt-4 lg:mt-8 lg:grid lg:grid-cols-4 lg:items-start lg:gap-8">
      <div class="hidden space-y-4 lg:block">
        <div>
          <label for="sort" class="block text-sm font-medium text-gray-700  dark:text-gray-300">
            {{ __('site.siralama') }}
          </label>
          <select name="sort" class="select-control my-2">
            <option value="price_asc">{{ __('site.fiyata_gore').', '.__('site.artan') }}</option>
            <option value="price_desc" @selected(request()->has('sort') && request()->sort=='price_desc')>{{ __('site.fiyata_gore').', '.__('site.azalan') }}</option>
            <option value="date_asc" @selected(request()->has('sort') && request()->sort=='date_asc')>{{ __('site.ilan_tarihine_gore').', '.__('site.artan') }}</option>
            <option value="date_desc" @selected(request()->has('sort') && request()->sort=='date_desc')>{{ __('site.ilan_tarihine_gore').', '.__('site.azalan') }}</option>
          </select>
        </div>

        <div>
          <div class="mt-1 space-y-2">
            <details open 
            class="overflow-hidden rounded border border-gray-300 dark:border-gray-800 [&_summary::-webkit-details-marker]:hidden">
              <summary class="flex cursor-pointer items-center justify-between gap-2 p-4 text-gray-900  dark:text-gray-400 transition">
                <span class="text-sm font-medium"> {{ __('site.filtreler') }} </span>

                <span class="transition group-open:-rotate-180">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                  </svg>
                </span>
              </summary>
              <div class="border-t border-gray-200 bg-gray-300 dark:bg-slate-700 px-4">
                <div class="py-2">
                  <label>{{ __('site.ilan-tipi') }}</label>
                  <select name="post_type" class="select-control my-2">
                    <option value="">{{ __('site.tumu') }}</option>
                    <option value="for_sale" @selected(request()->has('post_type') && request()->post_type=='for_sale') >{{ __('site.satilik') }}</option>
                    <option value="for_rent" @selected(request()->has('post_type') && request()->post_type=='for_rent') >{{ __('site.kiralik') }}</option>
                  </select>
                </div>
                <div class="py-2">
                  <label>{{ __('site.emlak-grubu') }}</label>
                  <select name="property_group" class="select-control my-2">
                    <option value="">{{ __('site.tumu') }}</option>
                    @foreach($emlakgruplari as $eg)
                    <option value="{{ $eg->id }}" @selected(request()->has('property_group') && request()->property_group==$eg->id)>{{  __('emlakgrubu.'.$eg->id) }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="py-2">
                  <label>{{ __('site.emlak-tipi') }}</label>
                  <select name="property_group" class="select-control my-2">
                    <option value="">{{ __('site.tumu') }}</option>
                    @foreach($emlaktipleri as $et)
                    <option value="{{ $et->id }}" @selected(request()->has('type') && request()->type==$et->id)>{{  __('emlaktipleri.'.$et->id) }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="py-2">
                  <label>{{ __('site.sehir') }}</label>
                  <select name="city" class="select-control my-2">
                    <option value="">{{ __('site.tumu') }}</option>
                    @foreach($iller as $il)
                      <option value="{{ $il->id }}" @selected(request()->has('city') && request()->city==$il->id)>{{  __('iller.'.$il->id) }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </details>
          </div>
        </div>
      </div>

      <div class="lg:col-span-3">
        <div class="grid gap-4 sm:grid-cols-1 lg:grid-cols-2">
          @foreach($emlaklar as $ilan)
          <x-anasayfa.emlak-card :emlak="$ilan" />
          @endforeach
        </div>
      </div>
    </div>
    <div class="flex justify-end py-10">
      {{ $emlaklar->links() }}
    </div>
  </div>
</section>
@endsection