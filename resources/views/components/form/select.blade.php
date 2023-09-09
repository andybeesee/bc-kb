@props(['name', 'display' => 'horizontal', 'emptyStart' => true, 'simpleArray' => false, 'label' => '', 'help' => '', 'value' => null, 'options' => null])

@php
    $inputId = $name.'-'.str($label)->slug();
    $hasError = $errors->first($name);
    $value = old($name, $value);
    $showRadios = false;
    $radioMAx = 10;
    if(is_numeric($value)) {
        $value = (int) $value;
    }

    if(!is_null($options)) {
        if(is_array($options) && count($options) < $radioMAx) {
            $showRadios = true;
        } elseif(method_exists($options, 'count') && $options->count() < $radioMAx) {
            $showRadios = true;
        }
    }
@endphp

<div class="form-group  {{ $display }} {{ $hasError ? 'has-validation' : '' }}">
    @if(!empty($label))
        <label for="{{ $inputId }}" class="form-label {{ $hasError ? 'error' : '' }}">
            {{ $label }}
        </label>
    @endif

    <div class="form-control-container">
        @if($showRadios)
            <div class="grid gap-1">
                @if($emptyStart)
                    <label class="flex items-center space-x-1">
                        <input
                            type="radio"
                            value=""
                            name="{{ $name }}"
                            {{ empty($value) ? "checked=checked" : '' }}
                        />
                        <span class="ml-1.5">No Selection</span>
                    </label>
                @endif
                @foreach($options as $optKey => $display)
                    <label class="flex items-center space-x-1">
                        @if($display instanceof \Illuminate\Database\Eloquent\Model)
                            <input
                                type="radio"
                                {{ $attributes->merge(['class' => ($hasError ? 'is-invalid' : '')]) }}
                                id="{{ $inputId }}"
                                value="{{ $display->getKey() }}"
                                name="{{ $name }}"
                                {{ $value === $display->getKey() ? "checked=checked" : '' }}
                            />
                            <span class="ml-1.5">{{ $display->name }}</span>
                        @else
                            @php $optValue = $simpleArray ? $display : $optKey; @endphp
                            <input
                                type="radio"
                                name="{{ $name }}"
                                {{ $attributes->merge(['class' => ($hasError ? 'is-invalid' : '')]) }}
                                {{ $optValue === $value ? 'checked=checked' : '' }}
                                value="{{ $optValue }}"
                            />
                            <span class="ml-1.5">{{ $display }}</span>
                        @endif

                    </label>
                @endforeach
            </div>
        @else
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
        @endif

        @if(!empty($help))
            <div class="text-sm text-zinc-700">{{ $help }}</div>
        @endif
        @if($hasError)
            <div class="invalid-feedback">{{ $errors->first($name) }}</div>
        @endif
    </div>
</div>
