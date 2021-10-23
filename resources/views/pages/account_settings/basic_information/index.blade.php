@extends('layouts.app')
@section('title', $title)

@section('content')

@include('includes.alerts')

<div class="row no-gutters align-items-start mx-4">
    @include('pages.account_settings.sidebar')
    @include('pages.account_settings.basic_information.form')
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $('#settings-form').on('submit', function(){
        $('#settings-form button').prop('disabled', true);
        $('#settings-form button').css('cursor', 'not-allowed');

        $('#btn-save').html('Saving Changes..');

        $(this).submit();
    });
});
</script>
@endsection