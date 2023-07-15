@extends('layout.app')
@section('content')
<section>
  <div class="relative mx-auto max-w-screen-xl px-4 py-8">
    <div>
      <h1 class="text-2xl font-bold lg:text-3xl">{{ $emlak->detay->baslik }}</h1>
      <p class="mt-1 text-sm text-gray-500">#{{ $emlak->ilan_no }}</p>
    </div>
    <div class="grid gap-8 lg:grid-cols-4 lg:items-start">
      <div class="lg:col-span-3" x-data="{
        aktifImage: '{{ Storage::url($emlak->gorseller[0]) }}'
      }">
        <div class="relative mt-4">
          <img :src="aktifImage" class="h-72 w-full rounded-xl object-cover lg:h-[540px]">
        </div>
        <ul class="mt-1 flex gap-1">
          @foreach($emlak->gorseller as $gorsel)
          <li>
            <img src="{{ Storage::url($gorsel) }}" class="h-16 w-16 rounded-md object-cover cursor-pointer" x-on:click="aktifImage = '{{ Storage::url($gorsel) }}'" />
          </li>
          @endforeach
        </ul>
      </div>
      <div class="lg:sticky lg:top-0 mt-3">
        <ul class="max-w-xs flex flex-col">
          <li class="inline-flex items-center flex justify-between gap-x-2 py-3 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            <span>{{ __('site.ilan-tipi') }}</span>
            <span class="font-bold">{{ __('site.'.$emlak->ilantipi) }}</span>
          </li>
          <li class="inline-flex items-center flex justify-between gap-x-2 py-3 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            <span>{{ __('site.fiyat') }}</span>
            <span class="font-bold">{{ number_format($emlak->fiyat[session('dovizcinsi')]->fiyat). ' '. $emlak->fiyat[session('dovizcinsi')]->sembol}}</span>
          </li>
          @foreach($emlak->grup->nitelikler as $n)
          <li class="inline-flex items-center flex justify-between gap-x-2 py-3 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            <span>{{ __('nitelik.'.$n) }}</span>
            <span class="font-bold">
              @isset($emlak->nitelikler[$n])
              @if(in_array($nitelikler[$n]['tip'], ['coklusecmeli','coktansecmeli']) )
              {{ 'nitelikdegeri.'.$n.'-deger-'.$emlak->nitelikler[$n]->deger }}

              @else
              {{ $emlak->nitelikler[$n]->deger }}
              @endif
              @endisset
            </span>
          </li>
          @endforeach
        </ul>
      </div>
      <div class="lg:col-span-3">
        <div class="border-b border-gray-200 dark:border-gray-700">
          <nav class="flex space-x-2" aria-label="Tabs" role="tablist">
            <button type="button" class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600 active" id="tab_aciklama-button" data-hs-tab="#tab_aciklama" aria-controls="tab_aciklama" role="tab">
              {{ __('site.aciklama') }}
            </button>
            <button type="button" class="hs-tab-active:font-semibold hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 py-4 px-1 inline-flex items-center gap-2 border-b-[3px] border-transparent text-sm whitespace-nowrap text-gray-500 hover:text-blue-600" id="tab_sokak_gorunumu-button" data-hs-tab="#tab_sokak_gorunumu" aria-controls="tab_sokak_gorunumu" role="tab">
            {{ __('site.sokak_gorunumu') }}
            </button>
          </nav>
        </div>

        <div class="mt-3">
          <div id="tab_aciklama" role="tabpanel" aria-labelledby="tabs-with-underline-item-1">
            <div class="prose max-w-none">
              <p>
                {{ $emlak->detay->aciklama }}
              </p>
              <h4 class="text-xl my-6">{{ __('site.ozellikler') }}</h4>
              <div class="grid gap-4 lg:gap-8  lg:grid-cols-3 grid-cols-1">
                @foreach($emlak->grup->ozellikgruplari as $o)
                <ul class="max-w-xs flex flex-col">
                  <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <span class="font-bold">{{ __('ozellikgruplari.'.$o) }}</span>
                  </li>
                  @foreach($ozellikler[$o] as $ozellik)
                  <li class="inline-flex items-center flex justify-between gap-x-2 py-3 px-4 text-sm font-medium bg-white border text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <span 
                      class="
                      @if(!isset($emlak->ozellikler[$ozellik->id]))
                        text-gray-400 dark:text-gray-500
                      @endif
                      "
                    >
                      {{ __('ozellik.'.$ozellik->id) }}
                    </span>
                    @if(isset($emlak->ozellikler[$ozellik->id]))
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-green-500 w-5 h-5"><title>check-bold</title><path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z" /></svg>
                    @endif
                  </li>
                  @endforeach
                </ul>
                @endforeach
              </div>
            </div>
          </div>
          <div id="tab_sokak_gorunumu" class="hidden" role="tabpanel" aria-labelledby="tabs-with-underline-item-2">
            <div id="map"></div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</section>
@if($maps_key != '')
<script type="text/javascript">
  function initMap() {
    const myLatLng = { lat: {{ $emlak->koordinatlar['latitude'] }}, lng: {{ $emlak->koordinatlar['longitude'] }} };
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 14,
      center: myLatLng,
    });

    new google.maps.Marker({
      position: myLatLng,
      map,
    });
  }
  window.initMap = initMap;
</script>
<script async
    src="https://maps.googleapis.com/maps/api/js?key={{ $maps_key }}&callback=initMap">
</script>
@endif
@endsection