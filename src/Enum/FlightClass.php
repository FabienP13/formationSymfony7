<?php 

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum FlightClass : string implements TranslatableInterface
{
    case ECONOMY = 'ECONOMY';
    case PREMIUM_ECONOMY = 'PREMIUM_ECONOMY';
    case BUSINESS = 'BUSINESS';
    case FIRST_CLASS = 'FIRST_CLASS';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string {
        return match($this) {
            self::ECONOMY => 'Économie',
            self::PREMIUM_ECONOMY => 'Économie Premium',
            self::BUSINESS => 'Affaire',
            self::FIRST_CLASS => 'Première Classe',
        };
    }
}