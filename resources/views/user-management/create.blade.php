@extends('layout.app')
@section('main-content')
<div class="card-body">
    <form method="POST" action="{{ url('users') }}">
        @csrf
        @include('user-management.form')
    </form>
</div>
@endsection
