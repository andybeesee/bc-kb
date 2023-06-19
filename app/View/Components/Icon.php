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

    const CUSTOM_ICONS = [
        'transfer' => [
            // Heroicons arrows-right-left
            'viewBox' => '0 0 24 24',
            'otherAttributes' => 'stroke-width=1.5 stroke=currentColor',
            'paths' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />'
        ],
        'samba' => [
            'viewBox' => '0 0 34 30',
            'otherAttributes' => '',
            'paths' => '<path stroke-linejoin="round" d="M 28.5,0.5 C 33.5191,2.7093 33.6858,5.37597 29,8.5C 28.5026,5.85397 28.3359,3.1873 28.5,0.5 Z"></path><path stroke-linejoin="round" d="M 5.5,2.5 C 12.8333,2.5 20.1667,2.5 27.5,2.5C 27.5,3.83333 27.5,5.16667 27.5,6.5C 21.1667,6.5 14.8333,6.5 8.5,6.5C 8.5,7.83333 8.5,9.16667 8.5,10.5C 14.1764,10.3339 19.8431,10.5006 25.5,11C 26,11.5 26.5,12 27,12.5C 27.6667,15.8333 27.6667,19.1667 27,22.5C 19.5871,23.4808 12.0871,23.8142 4.5,23.5C 4.5,22.1667 4.5,20.8333 4.5,19.5C 10.8333,19.5 17.1667,19.5 23.5,19.5C 23.5,18.1667 23.5,16.8333 23.5,15.5C 17.1667,15.5 10.8333,15.5 4.5,15.5C 4.23071,11.0685 4.56404,6.7352 5.5,2.5 Z"></path><path stroke-linejoin="round" d="M 3.5,26.5 C 3.16667,26.5 2.83333,26.5 2.5,26.5C 1.97439,24.7697 0.974395,23.4363 -0.5,22.5C -0.5,22.1667 -0.5,21.8333 -0.5,21.5C 0.428572,20.0639 1.59524,18.7305 3,17.5C 3.49796,20.4816 3.66463,23.4816 3.5,26.5 Z"></path>',
        ]
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
