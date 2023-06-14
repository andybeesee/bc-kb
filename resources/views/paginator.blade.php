@if ($paginator->hasPages())
    <div class="paginator w-full">
        {{-- Logic to handle advancing page in URL sometimes, based on turbo frame or not... --}}
        {{-- maybe something if referrer url mataches current url? --}}
        <div class="sm:hidden w-full flex py-2 items-center justify-between space-x-8">
            <!-- Mobile -->
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <div class="flex items-center text-secondary-400" aria-disabled="true">
                    <x-icon class="h-4 w-4 mr-3" icon="chevron-left" /> Previous
                </div>
            @else
                <a class="flex link items-center" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <x-icon class="h-4 w-4 mr-3" icon="chevron-left" /> Previous
                </a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="flex link items-center" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    Next <x-icon class="h-4 w-4 ml-3" icon="chevron-right" />
                </a>
            @else
                <div class="flex items-center text-secondary-400" aria-disabled="true">
                    Next <x-icon class="h-4 w-4 ml-3" icon="chevron-right" />
                </div>
            @endif
        </div>
        <nav class="hidden sm:flex justify-between">
            <!-- desktop view -->
            <div class="text-sm py-2 text-secondary-600">
                {!! __('Showing') !!}
                <span class="font-semibold">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="font-semibold">{{ $paginator->lastItem() }}</span>
                {!! __('of') !!}
                <span class="font-semibold">@number($paginator->total())</span>
                {!! __('results') !!}
            </div>

            <div class="flex items-center">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <div class="px-1.5 py-1 text-secondary-400" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">
                        <x-icon icon="chevron-left" class="h-4 w-4" />
                    </span>
                    </div>
                @else
                    <div class="px-1.5 py-1">
                        <a class="link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                            <x-icon icon="chevron-left" class="h-4 w-4" />
                        </a>
                    </div>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <div class="px-1.5 py-1 text-secondary-400" aria-disabled="true"><span class="link">{{ $element }}</span></div>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <div class="px-1.5 py-1 active" aria-current="page"><span>{{ $page }}</span></div>
                            @else
                                <div class="px-1.5 py-1"><a class="link" href="{{ $url }}">{{ $page }}</a></div>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <div class="px-1.5 py-1">
                        <a class="link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                            <x-icon icon="chevron-right" class="h-4 w-4" />
                        </a>
                    </div>
                @else
                    <div class="px-1.5 py-1 text-secondary-400" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="link" aria-hidden="true">
                        <x-icon icon="chevron-right" class="h-4 w-4" />
                    </span>
                    </div>
                @endif
            </div>
        </nav>
    </div>
@endif
