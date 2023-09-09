@props(['display' => 'horizontal', 'label' => '', 'help' => null, 'type' => 'text', 'value' => null])

<div class="form-group {{ $display }}">
    @if(!empty($label))
        <div class="form-label">
            {{ $label }}
        </div>
    @endif

    <div class="form-control-container">
        {{ $slot }}
    </div>
</div>
