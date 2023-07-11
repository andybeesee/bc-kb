@props(['name', 'label' => '', 'help' => null, 'type' => 'text', 'value' => null])

@php
    $inputId = $name.'-input';
    $value = old($name, $value);
    $hasError = $errors->has($name )
@endphp
<div class="form-group">
    <label for="{{ $inputId }}" class="form-label {{ $hasError ? 'error' : '' }}">
        {{ $label }}
    </label>

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $value }}"
        {{ $attributes->merge(['class' => "form-control ".($hasError ? 'error' : '')]) }}
    />

    @if(!empty($help))
        <div class="form-help">{{ $help }}</div>
    @endif

    @if($hasError)
        <div class="form-error">{{ $errors->first($name) }}</div>
    @endif
</div>
