<?php

namespace App\View;

class StatusColorUtils
{
    public static function getBackgroundColors($status) : string
    {
        $bgColors = ' hover:bg-zinc-100 hover:dark:bg-zinc-600';

        switch($status) {
            case 'idea':
                $bgColors = 'bg-sky-50 dark:bg-sky-800 hover:bg-sky-100 dark:hover:bg-sky-900';
                break;
            case 'pending':
                // $bgColors = '';
                break;
            case 'in_progress':
                // $bgColors = 'bg-indigo-50 dark:bg-indigo-800 hover:bg-indigo-100 dark:hover:bg-indigo-900';
                break;
            case 'complete':
                $bgColors = 'bg-emerald-50 dark:bg-emerald-800 hover:bg-emerald-100 dark:hover:bg-emerald-900';
                break;
            case 'late':
                $bgColors = 'bg-rose-50 dark:bg-rose-800 hover:bg-rose-100 dark:hover:bg-rose-900';
                break;
            case 'abandoned':
                // $bgColors = '';
                break;
        }

        return $bgColors;
    }

    public static function getTextColor($status)
    {
        $textColors = '';
        switch($status) {
            case 'idea':
                $textColors = 'text-sky-600 dark:text-sky-100';
                break;
            case 'pending':
                $textColors = 'text-zinc-500 dark:text-zinc-300';
                break;
            case 'in_progress':
                // $textColors = 'bg-indigo-50 dark:bg-indigo-800 hover:bg-indigo-100 dark:hover:bg-indigo-900';
                break;
            case 'complete':
                $textColors = 'text-emerald-600 dark:text-emerald-100';
                break;
            case 'late':
                $textColors = 'text-rose-600 dark:text-rose-100';
                break;
            case 'abandoned':
                $textColors = 'text-pink-600 dark:text-pink-400';
                break;
        }

        return $textColors;
    }

    public static function getIconColors($status) : string
    {
        switch ($status) {
            case 'idea':
                return 'bg-sky-50 dark:bg-sky-800 text-sky-700 dark:text-sky-50';
            case 'pending':
                return 'bg-zinc-200 dark:bg-zinc-700';
            case 'in_progress':
                return 'rounded-full bg-blue-600 border-blue-700';
            case 'complete':
                return 'rounded-full bg-emerald-200 border-emerald-400 text-emerald-900 dark:bg-emerald-300 dark:text-emerald-600';
            case 'late':
                return 'rounded-full bg-rose-200 border-rose-400 text-rose-900 dark:bg-rose-600 dark:text-white';
            case 'abandoned':
                return 'dark:text-pink-200 text-pink-500';
        }

        return '';
    }

    public static function getIcon($status) : string
    {
        switch ($status) {
            case 'idea':
                return 'lightbulb';
            case 'pending':
                return 'calendar';
            case 'in_progress':
                return 'circle';
            case 'complete':
                return 'check-circle';
            case 'late':
                return 'clock';
            case 'abandoned':
                return 'trash3';
        }
    }
}
