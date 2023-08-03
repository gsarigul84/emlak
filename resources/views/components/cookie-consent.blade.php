@if(!session()->has('cookie-consent') && isset($cookie_consent))
<div x-data="{
    accept(){
      fetch('{{ route('cookie-consent') }}');
    }
  }" id="cookies-simple-with-dismiss-button"
  class="fixed bottom-0 left-1/2 transform -translate-x-1/2 z-[60] sm:max-w-4xl w-full mx-auto p-6">
  <div class="p-4 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <div class="flex justify-between items-center gap-x-5 sm:gap-x-10">
      <h2 class="text-sm text-gray-600 dark:text-gray-400">
        {{ $cookie_consent['icerik'] }}
        <a class="inline-flex items-center gap-x-1.5 text-blue-600 decoration-2 hover:underline font-medium"
          href="#">Cookies Policy.</a>
      </h2>
      <button x-on:click="accept" type="button"
        class="inline-flex bg-gray-200 rounded-full p-3 text-gray-500 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-400"
        data-hs-remove-element="#cookies-simple-with-dismiss-button">
        <span>{{ __('site.kapat') }}</span>
      </button>
    </div>
  </div>
</div>
@endif