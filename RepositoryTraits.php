<?php

trait RepositoryTraits {
    protected Repository $repository;

    public function save(): void {
        // Зберігає рядок у базі даних
        $this->id = $this->repository->addRow($this->getValues());
    }

    public function update(): void {
        // Оновлює рядок у базі даних
        $this->repository->updateRow($this->id, $this->getValues());
    }

    public function delete(): void {
        // Видаляє рядок з бази даних
        $this->repository->removeRow($this->id);
    }

    public static function getAll($key = null): array {
        // Повертає масив усіх замовлень
        $repository = new Repository(self::TABLE, self::COLUMNS);
        $data = $repository->getAll();

        if ($key !== null) {
            // Якщо був заданий ключ, з яким бажано отримати масив таблиці SQL
            // При $eky = 'id', новим ключом кожного елементу стане значення id
            $reformattedData = [];
            foreach ($data as $element)
                $reformattedData[$element[$key]] = $element;
            return $reformattedData;
        }



        return $repository->getAll();
    }

    public static function getInfo(int $id): ?array {
        // Статичний метод, що повертає масив з інформацією о об'єкті. РЕКОМЕНДОВАНИЙ!
        $repository = new Repository(self::TABLE, self::COLUMNS);
        return $repository->getRow($id);
    }

    // Метод, що повертає об'єкт замовлення
    abstract static public function get(?int $id = null, ?string $name = null); // Повертає саме об'єкт, неоптимізований метод
    abstract public function getValues(): array;    // Метод, що повертає масив усіх даних, які потрібно ввести у базу даних
}