<div class="container">
    <span class="text-sm">Project Template</span>
    <h1>{{ $projectTemplate->name }}</h1>
    <p class="max-w-2xl mb-4">{{ $projectTemplate->description }}</p>
    <div
        class="card"
        x-data="{
            init() {
                new Sortable(this.$refs.groupList, {
                    handle: '.handle',
                    onEnd: () => {
                        const ids = Array.from(this.$refs.groupList.querySelectorAll(`[data-id]`))
                            .map(el => el.getAttribute('data-id'));

                        $wire.updateOrder(ids);
                    }
                });
            }
        }"
    >
        <div class="card-title">Task Groups</div>
        <div x-ref="groupList">
            {{-- TODO: INline sorting/editing right here to add/remove --}}
            @foreach($projectTemplate->taskGroupTemplates as $tgt)
                <div class="px-3 py-1 flex items-center" data-id="{{ $tgt->id }}">
                    <x-icon icon="grip-vertical" class="handle cursor-move h-3 w-3 mr-1" />
                    <a class="link" href="{{ route('task-group-templates.show', $tgt->id) }}">{{ $tgt->name }}</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
