@auth
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
    
    <div class="list-group accordion"
        id="accordion-parent">
    @if(isset($navigations))
    @foreach($navigations['user_levels'] as $level)
        @if($level->id == Auth::user()->user_level_id)
            @foreach($navigations['navs'] as $key => $nav)
    
            @php
            $modules = explode(',', $level->modules);
            $show = $nav['id'] == @$modules[$key];
            @endphp
    
            @if($nav['nav_type'] == "single")
            <a href="{{ url('/'.$nav['nav_route']) }}" id="{{ $nav['nav_route'] }}" class="{{ (!$show) ? 'd-none' : '' }} list-group-item list-group-item-action {{ $nav['nav_route'] }}">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="mr-3">
                            <i data-feather="{{ $nav['nav_icon'] }}"></i>
                        </span>
                        <span class="ellipsis">{{ $nav['nav_name'] }}</span>
                    </div>
                    {{-- <div class="text-right dr-{{ $nav['nav_route'] }}">
                        @if($nav['badge'])
                        <span class="badge badge-pill badge-danger">1</span>
                        @endif
                    </div> --}}
                </div>  
            </a>
            @elseif($nav['nav_type'] == "main")
            <button class="list-group-item list-group-item-action btn-item-nav {{ (!$show) ? 'd-none' : '' }}"
                id="{{ $nav['nav_route'] }}"
                data-toggle="collapse"
                data-target="#{{ __('collapse-').$nav['nav_route'] }}"
                aria-expanded="true"
                aria-controls="{{ __('collapse-').$nav['nav_route'] }}">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="mr-3">
                            <i data-feather="{{ $nav['nav_icon'] }}"></i>
                        </span>
                        <span class="d-inline-block text-truncate" style="max-width: 140px;">{{ $nav['nav_name'] }}</span>
                    </div>
                    <span class="chevron-size-md">
                        <i data-feather="chevron-right"></i>
                    </span>
                </div>
            </button>

            {{-- @foreach($nav['sub'] as $k => $sub)
            @php
            $sub_modules = explode(',', $level->sub_modules);
            dd($sub_modules);
            $show_sub = $sub['id'] == @$sub_modules[$k];
            @endphp
            @endforeach --}}

            <div class="collapse list-group bg-light" id="{{ __('collapse-').$nav['nav_route'] }}" aria-labelledby="{{ $nav['nav_route'] }}" data-parent="#accordion-parent">
                @foreach($nav['sub'] as $k => $sub)
                <a href="{{ url('/'.$sub['nav_route']) }}" id="{{ $sub['nav_route'] }}" class="list-group-item list-group-item-action {{ $sub['nav_route'] }}">
                    <div class="pl-2 d-flex align-items-center">
                        <span class="circle-size-sm mr-3">
                            <i data-feather="{{ $sub['nav_icon'] }}"></i>
                        </span>
                        <span class="d-inline-block text-truncate adjust-ellipsis" 
                            style="max-width: 140px;">{{ $sub['nav_name'] }}</span>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
            @endforeach
        @endif
    @endforeach
    @endif
    </div>
</aside>
@endauth