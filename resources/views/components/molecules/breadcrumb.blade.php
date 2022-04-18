@auth
<div class="mx-4 my-3">
    {{-- @if(count($breadcrumbs['name']) > 1)
    
    @endif --}}

    <div class="header mb-2">
        <ul class="breadcrumb-section">
            <li class="breadcrumb-items">
                <a href="/" title="Home"><i data-feather="home"></i> <span class="ml-1">Dashboard</span></a>
            </li>

            <li class="breadcrumb-items">
                <div class="chevrons-right">
                    <i data-feather="chevrons-right"></i>
                </div>
            </li>

            @for($i = 0; $i < count($breadcrumbs['name']); $i++)

            <li class="breadcrumb-items">
                {{-- <a href="{{ $breadcrumbs['mode'][$i] }}">{{ $breadcrumbs['name'][$i] }}</a> --}}
                <span>{{ $breadcrumbs['name'][$i] }}</span>
            </li>

            <li class="breadcrumb-items">
                <div class="chevrons-right">
                    <i data-feather="chevrons-right"></i>
                </div>
            </li>

            @endfor
        </ul>
    </div>

    <div class="header">
        <h3 class="mb-0">{{ $title }}</h3>
    </div>
</div>
@endauth