@props([
'emlak'
])
<a 
href="{{  route(app()->getLocale().'.emlakdetay', ['slug' => $emlak->detay->sef, 'id' => $emlak->id]) }}" 
class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7]">
<div 
  class="relative flex flex-col justify-center items-start bg-blue-600 rounded-t-xl"
  
>
    <img class="rounded-t-xl w-full" src="{{ Storage::url($emlak->gorseller[0]) }}" alt="{{ $emlak->ilan_no }}" />
    <div class="absolute top-0 left-0 transform translate-y-2 translate-x-2">
      <span class="ml-2 bg-blue-500 text-white py-1 px-2 text-xs font-bold transform rotate-45 -skew-x-12">
        {{ __('emlakgrubu.'.$emlak->grup_id) }} / {{ __('emlaktipleri.'.$emlak->tip_id) }}
      </span>  
      <span class="ml-2 bg-red-500 text-white py-1 px-2 text-xs font-bold uppercase transform rotate-45 -skew-x-12">
        {{ $emlak->ilantipi == 'satilik' ? __('site.satilik') : __('site.kiralik') }}
      </span>
    </div>
  </div>
  <div class="p-4 md:p-6">
    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-300 dark:hover:text-white">
      {{ $emlak->detay->baslik }}
    </h3>
    <p class="mt-3 text-gray-500">
      {{ $emlak->detay->aciklama }}
    </p>
  </div>
  <div class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
    <span class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 rounded-bl-xl font-medium bg-white text-gray-700 shadow-sm align-middle text-sm sm:p-4 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
    {{ __('site.ilan_no') }}: {{ $emlak->ilan_no }}
    </span>
    <span class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 font-medium bg-white text-gray-700 shadow-sm align-middle text-sm sm:p-4 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
    {{ $emlak->il->iladi }} / {{ $emlak->ilce->ilceadi }}
    </span>
    <span class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 rounded-br-xl font-medium bg-white text-gray-700 shadow-sm align-middle text-sm sm:p-4 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
    {{ number_format($emlak->fiyat[session('dovizcinsi')]?->fiyat, 0) }} {{ session('dovizcinsi')}}
    </span>
  </div>
</a>