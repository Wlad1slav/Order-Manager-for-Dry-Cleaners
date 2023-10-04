<?php

class Repository {
    // Абстракція для операцій з базою даних з використанням PDO
    // basic CRUD (Create, Read, Update, Delete)
    private PDO $connection; // властивість, що містить об’єкт з’єднання PDO
    private string $tableName; // властивість, яка відстежує назву таблиці, над якою виконуватимуться операції CRUD

    /**
     * @param string $tableName
     */
    public function __construct(string $tableName) {
        $this->tableName = $tableName;

        // Завантажує параметри підключення до бази даних із конфігураційного файлу
        $config = require 'settings.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->connection = new PDO($dsn, $config['user'], $config['pass'], $options);
    }

    public function addRow(array $columns, array $values): int { // Create
        // Вставляє новий рядок у таблицю.
        if (count($columns) !== count($values))
            // Перевіряє, чи однакова кількість стовпців і значень
            // Якщо ні, винекне помилка
            throw new InvalidArgumentException("addRow: Кількість стовпців і значення не збігаються.");

        $columnString = implode("`, `", $columns);
        $placeholders = implode(", ", array_fill(0, count($values), "?"));

        $query = "INSERT INTO `$this->tableName` (`$columnString`) VALUES ($placeholders)";

        // Готує SQL-запит. Цей метод повертає об’єкт PDOStatement.
        // Готуючи оператор, налаштовується запит на виконання у спосіб, який захищений від впровадження (injection) SQL.
        $stmt = $this->connection->prepare($query);

        // Виконання підготовленого оператора з фактичними значеннями.
        // Якщо виконання успішне, повертає останній вставлений ідентифікатор (який зазвичай є первинним ключем рядка).
        // Інакше повернути 0.
        return $stmt->execute($values) ? $this->connection->lastInsertId() : 0;
    }

    public function getAll(): array { // Read
        // Отримує всі рядки з таблиці
        $stmt = $this->connection->query("SELECT * FROM $this->tableName"); // stmt - statement
        return $stmt->fetchAll();
    }

    public function updateRow(int $id, array $columns, array $values): bool { // Update
        // Оновлює певний рядок, визначений ідентифікатором
        if (count($columns) !== count($values))
            // Перевіряє, чи однакова кількість стовпців і значень
            // Якщо ні, винекне помилка
            throw new InvalidArgumentException("updateRow: Кількість стовпців і значення не збігаються.");

        $set = [];
        foreach ($columns as $index => $column)
            $set[] = "`$column` = ?";

        $setString = implode(", ", $set);

        $query = "UPDATE `$this->tableName` SET $setString WHERE id = ?";

        // Готує SQL-запит. Цей метод повертає об’єкт PDOStatement.
        $stmt = $this->connection->prepare($query);

        // Додає ідентифікатор до кінця значень для WHERE умови
        $values[] = $id;

        // Виконання підготовленого оператора з фактичними значеннями.
        // Повертає true у разі успіху, інакше false.
        return $stmt->execute($values);
    }

    public function removeRow(int $id): int { // Delete
        // Видаляє певний рядок, визначений ідентифікатором.
        $query = "DELETE FROM `$this->tableName` WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

}