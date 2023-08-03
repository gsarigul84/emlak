
<footer class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6 mb-10">
    <div class="col-span-full hidden lg:col-span-1 lg:block">
      <a class="flex-none text-xl font-semibold dark:text-white" href="#">{{ config('app.name') }}</a>
      <p class="mt-3 text-xs sm:text-sm text-gray-600 dark:text-gray-400">© {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
    <div>
      <h4 class="text-xs font-semibold text-gray-900 uppercase dark:text-gray-100">Product</h4>
      <div class="mt-3 grid space-y-3 text-sm">
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200" href="#">Pricing</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200" href="#">Changelog</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200" href="#">Docs</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200" href="#">Download</a></p>
      </div>
    </div>

    <div>
      <h4 class="text-xs font-semibold text-gray-900 uppercase dark:text-gray-100">Company</h4>

      <div class="mt-3 grid space-y-3 text-sm">
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">About us</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">Blog</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">Careers</a> <span class="inline text-blue-600 dark:text-blue-500">— We're hiring</span></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">Customers</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">Newsroom</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">Sitemap</a></p>
      </div>
    </div>
    <div>
      <h4 class="text-xs font-semibold text-gray-900 uppercase dark:text-gray-100">Resources</h4>

      <div class="mt-3 grid space-y-3 text-sm">
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">Community</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">Help & Support</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">eBook</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">What's New</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">Status</a></p>
      </div>
    </div>
    <div>
      <h4 class="text-xs font-semibold text-gray-900 uppercase dark:text-gray-100">Developers</h4>

      <div class="mt-3 grid space-y-3 text-sm">
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">Api</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">Status</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">GitHub</a> <span class="inline text-blue-600 dark:text-blue-500">— New</span></p>
      </div>

      <h4 class="mt-7 text-xs font-semibold text-gray-900 uppercase dark:text-gray-100">Industries</h4>

      <div class="mt-3 grid space-y-3 text-sm">
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">Financial Services</a></p>
        <p><a class="inline-flex gap-x-2 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200"
            href="#">Education</a></p>
      </div>
    </div>
  </div>
  <div class="pt-5 mt-5 border-t border-gray-200 dark:border-gray-700">
    <div class="sm:flex sm:justify-between sm:items-center">
      <div class="flex items-center gap-x-3">
        <div class="flex justify-between items-center">
          <div class="mt-3 sm:hidden">
            <a class="flex-none text-xl font-semibold dark:text-white" href="#">{{ config('app.name') }}</a>
            <p class="mt-1 text-xs sm:text-sm text-gray-600 dark:text-gray-400">© {{ date('Y') }} {{ config('app.name')
              }}.</p>
          </div>
          <div class="space-x-4">
            @if(isset($ayarlar['twitter_url']) && trim($ayarlar['twitter_url']->deger) != '' )

            <a class="inline-block text-gray-500 hover:text-gray-800 dark:hover:text-gray-200" href="#">
              <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                viewBox="0 0 16 16">
                <path
                  d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
              </svg>
            </a>
            @endif
            @if(isset($ayarlar['instagram_url']) && trim($ayarlar['instagram_url']->deger) != '' )
            <a class="inline-block text-gray-500 hover:text-gray-800 dark:hover:text-gray-200"
              href="https://www.instagram.com/{{ $ayarlar['instagram_url']->deger }}">
              <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                viewBox="0 0 16 16">
                <title>instagram</title>
                <path
                  d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z" />
              </svg>
            </a>
            @endif
          </div>
        </div>
      </div>
    </div>
</footer>