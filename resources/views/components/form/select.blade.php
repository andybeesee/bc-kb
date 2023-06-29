@props(['name', 'emptyStart' => true, 'simpleArray' => false, 'label' => '', 'help' => '', 'value' => null, 'options' => null])

@php
    $inputId = $name.'-'.str($label)->slug();
    $hasError = $errors->first($name);
    $value = old($name, $value);

    if(is_numeric($value)) {
        $value = (int) $value;
    }
@endphp

<div class="from-group {{ $hasError ? 'has-validation' : '' }}">
    @if(!empty($label))
        <label for="{{ $inputId }}" class="form-label {{ $hasError ? 'error' : '' }}">
            {{ $label }}
        </label>
    @endif

    <select
        {{ $attributes->merge(['class' => 'form-control '.($hasError ? 'is-invalid' : '')]) }}
        id="{{ $inputId }}"
        value="{{ $value }}"
        name="{{ $name }}"
    >
        @if($emptyStart)
            <option value=""></option>
        @endif

        @if(is_null($options))
            {{ $slot }}
        @else
            @foreach($options as $optKey => $display)
                @if($display instanceof \Illuminate\Database\Eloquent\Model)
                    <option value="{{ $display->getKey() }}" {{ $value === $display->getKey() ? "selected=selected" : '' }}>
                        {{ $display->name }}
                    </option>
                @else
                    @php $optValue = $simpleArray ? $display : $optKey; @endphp
                    <option
                        {{ $optValue === $value ? 'selected=selected' : '' }}
                        value="{{ $optValue }}"
                    >{{ $display }}</option>
                @endif
            @endforeach
        @endif

    </select>

    @if(!empty($help))
        <div class="text-sm text-zinc-700">{{ $help }}</div>
    @endif
    @if($hasError)
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
</div>
