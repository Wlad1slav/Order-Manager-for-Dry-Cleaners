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

    public static function getAll(): array {
        // Повертає масив усіх замовлень
        $repository = new Repository(self::TABLE, self::COLUMNS);
        return $repository->getAll();
    }

    abstract static public function get();          // Метод, що повертає об'єкт замовлення
    abstract public function getValues(): array;    // Метод, що повертає масив усіх даних, які потрібно ввести у базу даних
}