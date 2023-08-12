@props(['date', 'format' => config('app.datetime_display'), 'timezone' => config('app.date_timezone')])


@if(!empty($date))
    @if($date instanceof \Carbon\Carbon)
        {{ $date->timezone($timezone)->format($format) }}
    @else
        {{ date($format, strtotime($date)) }}
    @endif
@endif
