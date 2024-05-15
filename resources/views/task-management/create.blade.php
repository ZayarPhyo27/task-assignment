@extends('layout.app')
@section('main-content')
<div class="card-body">
    <form method="POST" action="{{ url('tasks') }}">
        @csrf
        @include('task-management.form')
    </form>
</div>
@endsection
