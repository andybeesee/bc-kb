<div>
    @if ($paginator->hasPages())
        <div class="sm:hidden w-full flex py-2 items-center justify-between space-x-8">
            <!-- Mobile -->
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <div class="flex items-center text-secondary-400" aria-disabled="true">
                    <x-icon class="h-4 w-4 mr-3" icon="chevron-left" /> Previous
                </div>
            @else
                <button type="button" class="flex link items-center" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled">
                    <x-icon class="h-4 w-4 mr-3" icon="chevron-left" /> Previous
                </button>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button type="button" class="flex link items-center" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled">
                    Next <x-icon class="h-4 w-4 ml-3" icon="chevron-right" />
                </button>
            @else
                <div class="flex items-center text-secondary-400" aria-disabled="true">
                    Next <x-icon class="h-4 w-4 ml-3" icon="chevron-right" />
                </div>
            @endif
        </div>

        <nav class="hidden sm:flex justify-between">
            <!-- desktop view -->
            <div class="py-2 text-secondary-600">
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
                    <span aria-hidden="true" class="mt-1.5">
                        <x-icon icon="chevron-left" class="h-4 w-4" />
                    </span>
                    </div>
                @else
                    <div class="px-1.5 py-1">
                        <button type="button" class="mt-1.5 link" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled">
                            <x-icon icon="chevron-left" class="h-4 w-4" />
                        </button>
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
                                <div class="px-1.5 py-1">
                                    <button type="button" class="link" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">
                                        {{ $page }}
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <div class="px-1.5 py-1">
                        <button type="button" class="mt-1.5 link" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled">
                            <x-icon icon="chevron-right" class="h-4 w-4" />
                        </button>
                    </div>
                @else
                    <div class="px-1.5 py-1 text-secondary-400" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="mt-1.5 link" aria-hidden="true">
                        <x-icon icon="chevron-right" class="h-4 w-4" />
                    </span>
                    </div>
                @endif
            </div>
        </nav>
    @endif
</div>

