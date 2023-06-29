@if(!$breadcrumbs->isEmpty() && $breadcrumbs->count() > 1)
    {{-- TODO: We dont show the last 'active' item... seems unnecccesary? --}}
    <nav aria-label="breadcrumb" class="mt-2 breadcrumbs hidden md:flex items-center justify-center space-x-2 text-sm">
        @foreach ($breadcrumbs as $breadcrumb)

            @if(!$loop->first)
                <span>/</span>
            @endif

            @if ($breadcrumb->url && !$loop->last)
                <a class="link" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
            @else
                <span>{{ $breadcrumb->title }}</span>
            @endif

        @endforeach
    </nav>

    <nav aria-label="breadcrumb" class="breadcrumbs text-center mt-3 md:hidden">
        @php $bc = $breadcrumbs->reverse()->take(2)->last() @endphp
        <a class="inline-flex items-center link" href="{{ $bc->url }}">
            <x-icon icon="arrow-left" class="h-5 w-5 mr-1.5" />
            Back to {{ $bc->title }}
        </a>
    </nav>
@endif
