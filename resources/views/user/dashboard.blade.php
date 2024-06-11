@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="text-center">{{ __('Welcome User') }}</div>
        <div class="">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
        </div>    
    </div>
</div>
@endsection
