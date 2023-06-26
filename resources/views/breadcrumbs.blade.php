@if(!$breadcrumbs->isEmpty())
    {{-- TODO: We dont show the last 'active' item... seems unnecccesary? --}}
    <nav aria-label="breadcrumb" class="breadcrumbs hidden md:flex items-center space-x-2 text-sm">
        @foreach ($breadcrumbs as $breadcrumb)

            @if(!$loop->first && !$loop->last)
                <span>/</span>
            @endif

            @if ($breadcrumb->url && !$loop->last)
                <a class="link" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
            @else
                <!--span>{{ $breadcrumb->title }}</span-->
            @endif

        @endforeach
    </nav>

    <nav aria-label="breadcrumb" class="breadcrumbs md:hidden">
        @php $bc = $breadcrumbs->reverse()->take(2)->last() @endphp
        <a class="link" href="{{ $bc->url }}">
            Back to {{ $bc->title }}
        </a>
    </nav>
@endif
