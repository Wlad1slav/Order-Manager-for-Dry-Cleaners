<?php

class Utils {
    public function atLeast(int $value, int $num): int {
        // Перевіряє, чи число value більше num. Якщо ні, то повертає num
        if ($num > $value) return $num;
        return $value;
    }
    public function atLeastFloat(float $value, int $num): float {
        // Перевіряє, чи число value більше num. Якщо ні, то повертає num
        if ($num > $value) return $num;
        return $value;
    }
    public function validateName(string $name, string $placeError = 'Error'): void {
        if (strlen($name) == 0)
            throw new InvalidArgumentException("$placeError: Очікується непуста строка назви товару");
    }
}