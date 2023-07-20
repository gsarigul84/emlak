@extends('layout.app')
@section('content')
<div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-20">
  <h1 class="text-2xl">{{ $icerik->baslik }}</h1>
  <div class="py-4">
    {!! $icerik->icerik !!}
  </div>
</div>
@endsection