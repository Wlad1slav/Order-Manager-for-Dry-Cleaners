<?php

class PythonPhp {
    // Утилітарний клас для виконання сценаріїв Python у середовище PHP
    use JsonAccessTrait;

    const CONFIG_PATH = 'settings/config_python.json';
    const CONFIG_DEFAULT = [
        'System' => 'unix',
        'Command' => [
            'windows' => '.\\venv\\Scripts\\python',
            'unix' => 'source venv-unix/bin/activate',
        ],
        'Path' => [
            'windows' => 'venv\\Scripts\\python.exe',
            'unix' => 'venv-unix/bin/python3',
        ],
        'Version' => 'Python 3.11.7',
        'Folder' => 'scripts',
    ];

    public static function script(string $file, bool $debug = false): ?array {
        // Виконує python скрипт

        if (self::checkVenv()) { // Якщо існує venv
            $config = self::getJsonConfig();

            $command = $config['Command'][$config['System']];
            $folder = $config['Folder'];

            if ($debug) // Якщо увімкнений дебаг, то в output будуть виводитися помикли
                $add = '2>&1';
            else $add = '';

            exec("$command $folder\\$file $add", $output, $return);

            return [
                'output' => $output,
                'return' => $return
            ];
        }

        throw new InvalidArgumentException("Віртуального оточення для коректного виконання Python-скріпту не існує!");
    }

    public static function checkSystem(): void {
        // Визначення шляху до Python в залежності від системи
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            // Windows
            self::editJsonConfigElement(['System'], 'windows');
        else
            // Unix/Linux/Mac
            self::editJsonConfigElement(['System'], 'unix');

    }

    public static function checkVenv(): bool {
        // Перевірка, чи існує venv
        self::checkSystem(); // Визначення шляху до Python в залежності від системи
        $config = self::getJsonConfig();

        if (is_dir('venv') && file_exists("{$config['Path'][$config['System']]}"))
            return true;

        return false;
    }

}