<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Icon extends Component
{
    protected $base = 'bootstrap-icons';

    public $icon;

    protected $pack;

    public $svg;

    public $inline = true;

    public $style = '';

    const CUSTOM_ICONS = [
        'transfer' => [
            // Heroicons arrows-right-left
            'viewBox' => '0 0 24 24',
            'otherAttributes' => 'stroke-width=1.5 stroke=currentColor',
            'paths' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />'
        ],
    ];

    public static $svgs = [];

    public $iconId;

    public $viewBox;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon, $pack = '', $viewBox = null)
    {
        $this->iconId = 'icon-'.$icon;
        $this->icon = $icon;
        $this->style = $pack;
        $this->viewBox = $viewBox;

        if(isset(static::CUSTOM_ICONS[$icon])) {
            $this->svg = static::CUSTOM_ICONS[$icon];
            return;
        }

        // TODO: this could be better - less repetition somehow?
        // TODO: We could manually check to see if we're in a Turbo response...?

        if(!isset(static::$svgs[$this->iconId])) {
            if(!empty($pack)) {
                $path = resource_path($this->base.'/'.$pack.'/'.$icon.'.svg');
            } else {
                $path = resource_path($this->base.'/'.$icon.'.svg');
            }

            $contents = file_get_contents($path);

            $firstClosingAngle = strpos($contents, '>');

            // everything between <svg and >
            $ogAttributes = substr($contents, 4, $firstClosingAngle);
            if(!empty($this->viewBox)) {
                $viewBox = $this->viewBox;
            } else {
                $viewBox = str($ogAttributes)->after('viewBox="');
                $viewBox = str($viewBox)->before('"');
            }


            $paths = substr($contents, $firstClosingAngle + 1);
            $paths = str_replace('</svg>', '', $paths);

            $svg = [
                'paths' => $paths,
                'viewBox' => $viewBox,
            ];


            $this->svg = $svg;
            static::$svgs[$this->iconId] = $svg;
        } else {
            $this->svg = static::$svgs[$this->iconId];
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
return <<<'blade'
<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" {{ $svg['otherAttributes'] ?? '' }} viewBox="{{ $svg['viewBox'] }}" {{ $attributes->merge(['class' => 'icon']) }}>{!! $svg['paths'] !!}</svg>
blade;
    }
}
