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
                    <em data-feather="{{ $nav['nav_icon'] }}"></em>
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
                    <em data-feather="{{ $nav['nav_icon'] }}"></em>
                </span>
                <span class="d-inline-block text-truncate" style="max-width: 140px;">{{ $nav['nav_name'] }}</span>
            </div>
            <span class="chevron-size-md">
                <em data-feather="chevron-right"></em>
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

    <div class="list-group mx-2 collapse" id="{{ __('collapse-').$nav['nav_route'] }}" aria-labelledby="{{ $nav['nav_route'] }}" data-parent="#accordion-parent">
        @foreach($nav['sub'] as $k => $sub)
        <a href="{{ url('/'.$sub['nav_route']) }}" id="{{ $sub['nav_route'] }}" class="list-group-item list-group-item-action {{ $sub['nav_route'] }}">
            <div class="d-flex align-items-center">
                <span class="circle-size-sm mr-3">
                    <em data-feather="chevron-right"></em>
                </span>
                <span class="d-inline-block text-truncate adjust-ellipsis" 
                    style="max-width: 140px;">{{ $sub['nav_name'] }}</span>
            </div>
        </a>
        @endforeach
    </div>
    @endif
@endforeach