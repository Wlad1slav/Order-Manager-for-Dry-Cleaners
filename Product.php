<?php

class Product {
    private int $amount;        // Кількість шт.
    private float $price;       // Ціна за виріб
    private string $note;       // Примітки щодо товару
    private array $params;      // Словник додоткових параметрыв виробу
    private Goods $goods;       // Продукт виробу

    /**
     * @param int $amount
     * @param string $note
     * @param array $params
     * @param Goods $goods
     */
    public function __construct(int $amount, string $note, array $params, Goods $goods) {
        $this->amount = Utils::atLeast($amount, 1); // Utils
        $this->note = $note;
        $this->params = $params;
        $this->goods = $goods;
        $this->price = $this->goods->getPrice() * $this->amount;
    }

    public static function pullFromDB(int $id_order): array {
        // Витягує з бази даних масив виробів заданого замовлення
        $repository = new Repository('orders', Order::COLUMNS);
        $orderValues = $repository->getRow($id_order);
        $productions = json_decode($orderValues['productions'], true);

        $result = [];
        for ($i = 0; $i < count($productions['productions']); $i++)
            $result = [new Product(
                $productions['productions'][$i]['amount'],
                $productions['productions'][$i]['note'],
                $productions['productions'][$i]['params'],
                Goods::get($productions['productions'][$i]['goodID'])
            )];

        return $result;
    }

    public function getAmount(): int {
        // Повертає кількість товару в виробі
        return $this->amount;
    }
    public function setAmount(int $amount): void {
        // Встановлює кількість продукту в виробі
        $this->amount = Utils::atLeast($amount, 1); // Utils
    }

    public function getPrice(): float {
        // Повертає ціну за весь виріб
        return $this->price;
    }
    public function setPrice(float $price): void {
        // Встановлює ціну за весь виріб
        $this->price = Utils::atLeastFloat($price, 0); // Utils
    }

    public function getNote(): string {
        // Повертає нотатку до виробу
        return $this->note;
    }
    public function setNote(string $note): void {
        // Встановлює нотатки до виробу
        $this->note = $note;
    }

    public function getParams(): array {
        // Повертає словник параментрів до виробу
        return $this->params;
    }
    public function setParams(array $params): void {
        // Встановлює словник параметрів до виробу
        $this->params = $params;
    }

    public function getGoods(): Goods {
        // Повертає продук виробу
        return $this->goods;
    }
    public function setGoods(Goods $goods): void {
        // Встановлює продук виробу
        if (!$goods instanceof Goods)
            throw new InvalidArgumentException('setGoods(Goods goods): Очікується об\'єкт класу Goods');
        $this->goods = $goods;
    }

}