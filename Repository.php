<?php

class Repository {
    // Абстракція для операцій з базою даних з використанням PDO
    // basic CRUD (Create, Read, Update, Delete)
    private PDO $connection; // властивість, що містить об’єкт з’єднання PDO
    private string $tableName; // властивість, яка відстежує назву таблиці, над якою виконуватимуться операції CRUD
    private array $columns; // властивість, що містить масив усіх столбців бд з яким потрібно роботати

    /**
     * @param string $tableName
     * @param array $columns
     */
    public function __construct(string $tableName, array $columns) {
        // Завантажує параметри підключення до бази даних із конфігураційного файлу
        $config = require 'settings/db_config.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->connection = new PDO($dsn, $config['user'], $config['pass'], $options);

        // Дані о таблиці з якою потрібно буде роботати
        $this->checkTable($tableName);
        $this->tableName = $tableName;
        $this->columns = $columns;
    }

    public function addRow(array $values): int { // Create
        // Вставляє новий рядок у таблицю.
        if (count($this->columns) !== count($values))
            // Перевіряє, чи однакова кількість стовпців і значень
            // Якщо ні, винекне помилка
            throw new InvalidArgumentException("addRow: Кількість стовпців і значення не збігаються.");


        foreach ($values as &$value)
            if ($value instanceof DateTime) // Конвертує об'єкт DateTime у строковий формат
                $value = $value->format('Y-m-d H:i:s');
            elseif(is_bool($value)) // Конвертує t/f у формат, у якому вони зберігаються у БД
                if($value == true) $value = 1;
                else $value = 0;

        $columnString = implode("`, `", $this->columns);
        $placeholders = implode(", ", array_fill(0, count($values), "?"));

        $query = "INSERT INTO `$this->tableName` (`$columnString`) VALUES ($placeholders)";
        // echo $query;

        // Готує SQL-запит. Цей метод повертає об’єкт PDOStatement.
        // Готуючи оператор, налаштовується запит на виконання у спосіб, який захищений від впровадження (injection) SQL.
        $stmt = $this->connection->prepare($query);

        // Виконання підготовленого оператора з фактичними значеннями.
        // Якщо виконання успішне, повертає останній вставлений ідентифікатор (який зазвичай є первинним ключем рядка).
        // Інакше повернути 0.
        return $stmt->execute($values) ? $this->connection->lastInsertId() : 0;
    }

    private function checkTable(string $tableName): void { // Read-Create
        // Перевіряє, чи існує таблиця в базі даних
        $query = "SHOW TABLES LIKE " . $this->connection->quote($tableName);
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $this->tableName = $tableName;
        }
        else { // Якщо ні, то назва таблиці шукається у масиві заготовок, після чого створюється на основі заготовки
            $tables = require 'settings/table_templates.php';
            foreach ($tables as $table => $query)
                if ($table == $tableName) {
                    $this->connection->exec($query);
                    return;
                }
            // Якщо немає заготовки для таблиці, то виникає помилка
            throw new InvalidArgumentException("checkTable(string $tableName): Таблиці $tableName не існує. Ймовірно, вона була випадково видалена, створить нову, будь ласка.");
        }
    }

    public function getAll(): array { // Read
        // Отримує всі рядки з таблиці
        $stmt = $this->connection->query("SELECT * FROM $this->tableName");
        return $stmt->fetchAll();
    }
    
    public function getRow(int $id): array { // Read
        // Отримує окремий рядок з таблиці, знаходячи його по id
        $stmt = $this->connection->prepare("SELECT * FROM $this->tableName WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function updateRow(int $id, array $values): bool { // Update
        // Оновлює певний рядок, визначений ідентифікатором
        if (count($this->columns) !== count($values))
            // Перевіряє, чи однакова кількість стовпців і значень
            // Якщо ні, винекне помилка
            throw new InvalidArgumentException("updateRow: Кількість стовпців і значення не збігаються.");

        if ($id < 1)
            throw new InvalidArgumentException("updateRow: Замовлення з id $id не існує.");

        foreach ($values as &$value)
            if ($value instanceof DateTime) // Конвертує об'єкт DateTime у строковий формат
                $value = $value->format('Y-m-d H:i:s');
            elseif(is_bool($value)) // Конвертує t/f у формат, у якому вони зберігаються у БД
                if($value == true) $value = 1;
                else $value = 0;

        $set = [];
        foreach ($this->columns as $index => $column)
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