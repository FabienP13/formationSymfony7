<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum TransportType : string implements TranslatableInterface
{
    case PLANE = 'PLANE';
    case TRAIN = 'TRAIN';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string {
        return match($this) {
            self::PLANE => 'Avion',
            self::TRAIN => 'Train',
        };
    }
}