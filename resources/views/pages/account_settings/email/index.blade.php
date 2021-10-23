@extends('layouts.app')
@section('title', $title)

@section('content')

@include('includes.alerts')

<div class="row no-gutters align-items-start mx-4">
    @include('pages.account_settings.sidebar')
    @include('pages.account_settings.email.form')
</div>

@endsection