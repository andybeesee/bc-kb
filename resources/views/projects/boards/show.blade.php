<x-layouts.board-layout :project="$project" :board="$board" title="Baord detail">
    <div>
        {{--TODO: we want the columns full availavle height with scrolling --}}
        {{-- TODO: we need to calculate max height and do ti that way? --}}
        {{--TODO: scroll in to view, or dosomething with Turbo? --}}

        <div class="col-span-3 full-body-scroll-column h-full" id="board-detail">
            <div class="well w-full">
                <div class="">
                    comments, files, tasks on board all that jazz goes here in a scrolling way
                </div>
            </div>
        </div>
    </div>
</x-layouts.board-layout>
