@php 
$style = (session()->get('display') === "false") ? "width: 0px; opacity: 0;" : "";
@endphp

<aside class="sidebar d-none d-lg-flex py-4" id="sidebar" style="{{ $style }}">
    <div class="branding-logo w-100 position-sticky fixed-top mb-4">
        <img src="{{ asset('images/logo/login-banner.png') }}" alt="logo">
        {{-- <div class="h4 text-center">
            <div class="icon-sample mb-2"><i data-feather="grid"></i></div>
            <div class="logo-name font-weight-500">{{ config('app.name', 'Framework') }}</div>
        </div> --}}
        <button type="button" class="btn d-block d-lg-none" id="btn-close">
            <i data-feather="x"></i>
        </button>
    </div>
    
    <div class="list-group accordion" id="accordion-parent">
    @if(isset($navigations))
    @foreach($navigations['user_levels'] as $level)
        @if($level->id == Auth::user()->user_level_id)
            <x-molecules.accordion 
                :level="$level"
                :navigations="$navigations" />
        @endif
    @endforeach
    @endif
    </div>
</aside>