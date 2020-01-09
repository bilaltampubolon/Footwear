@extends('layouts.app')

@section('content')
    <div class="  px-3 lg:px-12 bg-gray-300">

          @if($category)
          <add-cart :product="{{ $product }}"  :category="{{ $category }}" :recommended="{{ $recommended }}"/> 
          @else
          <add-cart :product="{{ $product }}"  :recommended="{{ $recommended }}"/> 
          @endif

          
    </div>
@endsection
