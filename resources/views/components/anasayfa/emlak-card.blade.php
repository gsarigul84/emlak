@props([
'emlak'
])
<a href="{{  route(app()->getLocale().'.emlakdetay', ['slug' => $emlak->detay->sef, 'id' => $emlak->id]) }}" class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7]">
  <div class="flex flex-col justify-center items-center bg-blue-600 rounded-t-xl">
    <img class="rounded-t w-full" src="{{ Storage::url($emlak->gorseller[0]) }}" alt="{{ $emlak->ilan_no }}" />
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
    <span class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 rounded-bl-xl font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm sm:p-4 dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" href="#">
    {{ $emlak->il->iladi }} / {{ $emlak->ilce->ilceadi }}
    </span>
    <span class="w-full py-3 px-4 inline-flex justify-center items-center gap-2 rounded-br-xl font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm sm:p-4 dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" href="#">
    {{ number_format($emlak->fiyat[session('dovizcinsi')]->fiyat, 0) }} {{ session('dovizcinsi')}}
    </span>
  </div>
</a>