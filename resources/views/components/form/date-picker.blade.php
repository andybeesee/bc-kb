@props(['name', 'style' => 'horizontal', 'label' => '', 'help' => null, 'type' => 'text', 'value' => null])

@php
    // TODO: I'd like something that worked witht he keyboard...
    // TODO: we could put shortcuts on here eg 'today', '6 weeks from today', 'next week'
    $inputId = $name.'-input';
    $value = old($name, $value);
    $wiremodel = $attributes->wire('model')->value();
    $errorName = empty($wiremodel) ? $name : $wiremodel;
    $hasError = $errors->has($errorName )
@endphp
<div
    class="form-group {{ $style }}"
    x-data="{
        date: @entangle($attributes->wire('model')),
        formattedDate: null,
        calendarIsOpen: false,
        init() {
            if(!this.date) {
                this.formattedDate = 'Not Set';
            } else {
                this.updateDate(new Date(this.date));
            }
        },
        openCalendar() {
            this.calendarIsOpen = true;
            this.picker = flatpickr(this.$refs.input, {
                inline: true,
                onChange: (date, dateString) => {
                    this.updateDate(date[0]);
                    this.closeCalendar();
                },
            });
        },
        updateDate(date) {
            this.date = date.toISOString().slice(0, 10);
            this.formattedDate = date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric'});
        },
        closeCalendar() {
            this.calendarIsOpen = false;
            this.picker.destroy()
        },
        removeDate() {
            this.date = null;
            this.formattedDate = 'Not Set';
            this.closeCalendar();
        }
    }"
>
    @if(!empty($label))
        <label for="{{ $inputId }}" class="form-label {{ $hasError ? 'error' : '' }}">
            {{ $label }}
        </label>
    @endif

    <div class="form-control-container">
        <input
            type="hidden"
            name="{{ $name }}"
            value="{{ $value }}"
            {{ $attributes->merge(['class' => "".($hasError ? 'error' : '')]) }}
        />

        <button x-ref="btn" @click="openCalendar" type="button" class="form-control flex items-center hover:bg-zinc-100">
            <span x-html="formattedDate"></span>
            <span class="ml-auto flex items-center">
            <x-icon @click.self.stop="removeDate" x-show="date" icon="x-circle" class="h-4 w-4 text-red-600 hover:text-white rounded-full hover:bg-red-600 ml-auto mr-2" />
            <x-icon icon="calendar" class="h-4 w-4" />
            </span>

        </button>

        <div  class="absolute shadow bg-white z-[10]" x-show="calendarIsOpen" style="display: none" @click.outside="closeCalendar">
            <button x-show="date" @click="removeDate" type="button" class="w-full bg-red-100 hover:bg-red-200 dark:bg-red-700 dark:hover:bg-red-800 py-0.5 rounded-md mb-0.5">Remove Date</button>
            <input type="text" x-ref="input" placeholder="text" class="w-[100px] border" style="display: none"/>
        </div>

        @if(!empty($help))
            <div class="form-help">{{ $help }}</div>
        @endif

        @if($hasError)
            <div class="form-error">{{ $errors->first($errorName) }}</div>
        @endif
    </div>
</div>
