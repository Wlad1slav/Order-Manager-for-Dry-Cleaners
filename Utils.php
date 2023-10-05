<?php

class Utils {
    public static function atLeast(int $value, int $num): int {
        // Перевіряє, чи число value більше num. Якщо ні, то повертає num
        if ($num > $value) return $num;
        return $value;
    }
    public static function atLeastFloat(float $value, int $num): float {
        // Перевіряє, чи число value більше num. Якщо ні, то повертає num
        if ($num > $value) return $num;
        return $value;
    }
    public static function validateName(string $name, string $placeError = 'Error'): void {
        if (strlen($name) == 0)
            throw new InvalidArgumentException("$placeError: Очікується непуста строка назви товару");
    }
}