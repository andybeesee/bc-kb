@props(['name', 'display' => 'horizontal', 'label' => '', 'help' => null, 'type' => 'text', 'value' => null])

@php
    $inputId = $name.'-input-'.str($value)->slug()->toString();
    $value = old($name, $value);
    $wiremodel = $attributes->wire('model')->value();
    $errorName = empty($wiremodel) ? $name : $wiremodel;
    $hasError = $errors->has($errorName )
@endphp
<div class="flex items-center">
    <input
        id="{{ $inputId }}"
        type="radio"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $attributes->merge(['class' => ($hasError ? 'error' : '')]) }}
    />

    <div class="ml-2">
        <label for="{{ $inputId }}" class="form-label-radio {{ $hasError ? 'error' : '' }}">
            {{ $label }}
        </label>
        @if(!empty($help))
            <div class="form-help">{{ $help }}</div>
        @endif

        @if($hasError)
            <div class="form-error">{{ $errors->first($errorName) }}</div>
        @endif
    </div>
</div>
