<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite([
    'resources/css/app.css',
    'resources/js/app.js'
  ])
</head>
<body class="dark:bg-slate-800 dark:text-gray-400 text-gray-800 bg-slate-200">
  @include('layout.header')
  <div class="min-h-screen">
    @yield('content')
  </div>
  @include('layout.footer')
</body>
</html>