<?php

namespace App\Enum;

enum Section : string
{
    case HERO_SECTION = 'hero_section';
    case EDUCATION_SECTION = 'education_section';
    case CONSULTATION_SECTION = 'consultation_section';
    case HELP_SECTION = 'help_section';
    case HELP_SECTION_ITEMS = 'help_section_items';

    case ABOUT_US_SECTION = 'about_us_section';
    case EMPOWERED_CLIENTS = 'empowered_clients';
    case PATIENT_SATISFACTION = 'patient_satisfaction';
    case EXPERIENCE = 'experience';
    case CERTIFIED_EXPERT = 'certified_expert';
    case EMPLOYEES = 'employees';



    case WHY_CHOOSE_US_SECTION = 'why_choose_us_section';

    public static function getHome()
    {
        return [
            self::HERO_SECTION->value => ['item' => 1, 'type' => 'first'],
            self::EDUCATION_SECTION->value => ['item' => 1, 'type' => 'first'],
            self::CONSULTATION_SECTION->value => ['item' => 1, 'type' => 'first'],
            self::HELP_SECTION->value => ['item' => 1, 'type' => 'first'],
            self::HELP_SECTION_ITEMS->value => ['item' => 4, 'type' => 'get'],
        ];
    }

    public static function getAboutUs()
    {
        return [
            self::ABOUT_US_SECTION->value => ['item' => 1, 'type' => 'first'],
            self::EMPOWERED_CLIENTS->value => ['item' => 1, 'type' => 'first'],
            self::PATIENT_SATISFACTION->value => ['item' => 1, 'type' => 'first'],
            self::EXPERIENCE->value => ['item' => 1, 'type' => 'first'],
            self::CERTIFIED_EXPERT->value => ['item' => 1, 'type' => 'first'],
            self::EMPLOYEES->value => ['item' => 1, 'type' => 'first'],
        ];
    }

    public static function getWhyChooseUs()
    {
        return [
            self::WHY_CHOOSE_US_SECTION->value => ['item' => 4, 'type' => 'get'],
        ];
    }
}
