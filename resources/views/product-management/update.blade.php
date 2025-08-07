@extends('layout.app')
@section('main-content')
<div class="card-body">
    <form method="POST" enctype="multipart/form-data" action="{{ url('products/'.$product->id) }}">
        @csrf
        @method('PUT')
        @include('product-management.form')
    </form>
</div>
@endsection
