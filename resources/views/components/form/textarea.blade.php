@props(['name', 'label' => '', 'help' => null, 'type' => 'text', 'value' => null])

@php
    $inputId = $name.'-input';
    $value = old($name, $value);
    $errorName = $attributes->wire('model')->value() ?? $name;
    $hasError = $errors->has($errorName)
@endphp
<div class="form-group">
    <label for="{{ $inputId }}" class="form-label {{ $hasError ? 'error' : '' }}">
        {{ $label }}
    </label>

    <div class="form-control-container">
        <textarea
            {{ $attributes->merge() }}
            name="{{ $name }}"
            class="form-control {{ $hasError ? 'error' : '' }}"
        >{{ $value }}</textarea>

        @if(!empty($help))
            <div class="form-help">{{ $help }}</div>
        @endif

        @if($hasError)
            <div class="form-error">{{ $errors->first($errorName) }}</div>
        @endif
    </div>
</div>
