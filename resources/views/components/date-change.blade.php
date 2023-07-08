@props([
    'date',
    'modelId',
    'placeholder' => 'No Date',
    'title' => 'Date',
    'prefix' => '',
    'suffix' => '',
    'changeEvent' => 'updateDate',
    'removeEvent' => 'removeDate',
])

<div
    x-data="{
    calendarIsOpen: false,
    openCalendar() {
        this.calendarIsOpen = true;
        this.picker = flatpickr(this.$refs.input, {
            inline: true,
            onChange: (date, dateString) => {
                Livewire.emit('{{ $changeEvent }}', '{{ $modelId }}', date[0].toISOString().slice(0, 10))
                this.closeCalendar();
            },
        });
    },
    closeCalendar() {
        this.calendarIsOpen = false;
        this.picker.destroy()
    },
    removeDate() {
        Livewire.emit('{{ $removeEvent  }}', '{{$modelId}}');
        this.closeCalendar();
    }
}"
{{ $attributes->merge() }}
>
    <button
        title="{{ $title }}"
        type="button"
        @click="openCalendar"
        class="flex items-center px-1 py-0.5 rounded-md hover:bg-zinc-100"
    >
        @if($date)
            @if(!empty($prefix))
                <span class="mr-1">{{ $prefix }}</span>
            @endif
            <span>
                {{ $date->format(config('app.date_display')) }}
            </span>
                @if(!empty($suffix))
                    <span class="ml-1">{{ $suffix }}</span>
                @endif
        @else
            <span class="text-zinc-400">{{ $placeholder }}</span>
        @endif
    </button>

    <div  class="absolute shadow bg-white z-[10]" x-show="calendarIsOpen" style="display: none" @click.outside="closeCalendar">
        @if(!empty($date))
            <button @click="removeDate" type="button" class="w-full bg-red-100 hover:bg-red-200 py-0.5 rounded-md mb-0.5">Remove Date</button>
        @endif
        <input type="text" x-ref="input" placeholder="text" class="w-[100px] border" style="display: none"/>
    </div>
    {{-- Stop trying to control. --}}
</div>
