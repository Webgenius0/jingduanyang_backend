<?php

namespace App\Enum;

enum Section : string
{
    case HERO_SECTION = 'hero_section';

    case ABOUT_US_SECTION = 'about_us_section';

    public static function getHome()
    {
        return [
            self::HERO_SECTION->value => ['item' => 1, 'type' => 'first'],
        ];
    }

    public static function getAboutUs()
    {
        return [
            self::ABOUT_US_SECTION->value => ['item' => 1, 'type' => 'first'],
        ];
    }
}
