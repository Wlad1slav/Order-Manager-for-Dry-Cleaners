<?php

class Product {
    private int $amount;        // Кількість шт.
    private float $price;       // Ціна за виріб
    private int $discount;      // Знижка на виріб
    private string $note;       // Примітки щодо товару
    private string $params;     // Словник додаткових параметрів виробу (JSON)
    private Goods $goods;       // Продукт виробу

    /**
     * @param int $amount
     * @param string $note
     * @param array $params
     * @param Goods $goods
     * @param int $discount
     * @param float|null $price
     */
    public function __construct(int $amount, string $note, array $params, Goods $goods, int $discount=0, ?float $price=null) {
        $this->amount = Utils::atLeast($amount, 1); // Utils
        $this->note = $note;
        $this->params = json_encode($params);
        $this->goods = $goods;

        if ($discount >= 0 && $discount < 100)
            $this->discount = $discount;
        else $this->discount = 0;

        if ($price === null) { // Якщо ціна не вказана, то вона вираховується автоматично
            $this->price = $this->goods->getPrice() * $this->amount;
            $this->price -= $this->price / 100 * $this->discount;
        }
        else $this->price = $price;

    }

    public static function pullFromDB(int $id_order): array {
        // Витягує з бази даних масив виробів заданого замовлення
        $repository = new Repository(Order::TABLE, Order::COLUMNS);
        $orderValues = $repository->getRow($id_order);
        $productions = json_decode($orderValues['productions'], true);

        $result = [];
        for ($i = 0; $i < count($productions['productions']); $i++)
            $result = [new Product(
                $productions['productions'][$i]['amount'],
                $productions['productions'][$i]['note'],
                $productions['productions'][$i]['params'],
                Goods::get($productions['productions'][$i]['goodID']),
                $productions['productions'][$i]['discount'],
                $productions['productions'][$i]['price'],
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

    public function getParams() {
        // Повертає словник параментрів до виробу
        return json_decode($this->params);
    }
    public function setParams(array $params): void {
        // Встановлює словник параметрів до виробу
        $this->params = json_encode($params);
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

    public function getDiscount(): int {
        // Повертає знижку на виріб
        return $this->discount;
    }
    public function setDiscount(int $discount): void {
        // Встановлює знижку на виріб
        $this->discount = $discount;
    }

}