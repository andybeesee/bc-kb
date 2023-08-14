@props(['name', 'display' => 'horizontal', 'label' => '', 'help' => null, 'type' => 'text', 'value' => null])

@php
    $inputId = $name.'-input';
    $value = old($name, $value);
    $wiremodel = $attributes->wire('model')->value();
    $errorName = empty($wiremodel) ? $name : $wiremodel;
    $hasError = $errors->has($errorName )
@endphp
<div class="form-group {{ $display }}">
    @if(!empty($label))
        <label for="{{ $inputId }}" class="form-label {{ $hasError ? 'error' : '' }}">
            {{ $label }}
        </label>
    @endif

    <div class="form-control-container checkbox">
        <input
            type="checkbox"
            name="{{ $name }}"
            value="{{ $value }}"
            {{ $attributes->merge(['class' => "form-control ".($hasError ? 'error' : '')]) }}
        />

        @if(!empty($help))
            <div class="form-help">{{ $help }}</div>
        @endif

        @if($hasError)
            <div class="form-error">{{ $errors->first($errorName) }}</div>
        @endif
    </div>
</div>
