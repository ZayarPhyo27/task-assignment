@extends('layout.app')
@section('main-content')
<div class="card-body">
    <form method="POST" action="{{ url('users/'.$user->id) }}">
        @csrf
        @method('PUT')
        @include('user-management.form')
    </form>
</div>
@endsection



