@props(['name', 'label' => '', 'help' => null, 'type' => 'text', 'value' => null])

@php
    $inputId = $name.'-input';
    $value = old($name, $value);
    $hasError = $errors->has($name )
@endphp
<div class="form-group" {{ $type === 'date' ? 'data-controller=date-picker' : '' }}>
    <label for="{{ $inputId }}" class="form-label {{ $hasError ? 'error' : '' }}">
        {{ $label }}
    </label>

    @if($type === 'date')
        <duet-date-picker
            data-date-picker-target="input"
            name="{{ $name }}"
            identifier="{{ $inputId }}"
            value="{{ $value }}"
            data-action="click->date-picker#open"
        />
    @else
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ $value }}"
            class="form-control {{ $hasError ? 'error' : '' }}"
        />
    @endif


    @if(!empty($help))
        <div class="form-help">{{ $help }}</div>
    @endif

    @if($hasError)
        <div class="form-error">{{ $errors->first($name) }}</div>
    @endif
</div>
