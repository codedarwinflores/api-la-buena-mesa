<?php

namespace App\Enums;

enum MenuCategory: string
{
    case ENTRADA = 'entrada';
    case PLATO_FUERTE = 'plato_fuerte';
    case POSTRE = 'postre';
    case BEBIDA = 'bebida';
    case ACOMPANAMIENTO = 'acompanamiento';

    public function label(): string
    {
        return match ($this) {
            self::ENTRADA => 'Entrada',
            self::PLATO_FUERTE => 'Plato Fuerte',
            self::POSTRE => 'Postre',
            self::BEBIDA => 'Bebida',
            self::ACOMPANAMIENTO => 'Acompañamiento',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
