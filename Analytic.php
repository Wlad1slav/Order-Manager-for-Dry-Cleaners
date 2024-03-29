<?php

require_once 'Order.php';


class Analytic {
    // Клас, що призначений для аналізу та агрегування даних про замовлення. Надає вичерпні дані про замовлення
    // за різні періоди часу та атрибути, для аналітики та звітності.
    private array $orders; // Масив усіх замовлень

    const DATE_FORMAT = 'Y-m-d';
    const POSSIBLE_ORDER_ATTRIBUTES = [
        'date_create',
        'date_end',
        'date_payment',
        'date_closing',
        'date_last_update',
    ];

    /**
     * @param array|null $orders
     */
    public function __construct(array $orders = null) {
        if ($orders === null)
            $orders = Order::getAll('id');
        $this->orders = $orders;
    }

    public function get(): array {
        return [
            'Today' => $this->getAllOrdersByAllPossibleDates(date(self::DATE_FORMAT)),
            'Yesterday' => $this->getAllOrdersByAllPossibleDates(
                date(self::DATE_FORMAT, strtotime("-1 day") // Вчорашніj день
                )
            ),

            'Month' => $this->getAllOrdersForPeriodByAllPossibleDates([
                    'start' => date('Y-m-01'),         // Першиj день поточного місяця
                    'end' => date(self::DATE_FORMAT)
                ]
            ),
            'LastMonth' => $this->getAllOrdersForPeriodByAllPossibleDates([
                'start' => date('Y-m-01', strtotime("-1 month")), // Першиj день минулого місяця
                'end' => date(self::DATE_FORMAT, strtotime("-1 month")) // День в минулому місяці,
                // що відповідає сьогоднішьому
            ]),
            'WholeLastMonth' => $this->getAllOrdersForPeriodByAllPossibleDates([
                'start' => date('Y-m-01', strtotime("-1 month")), // Першиj день минулого місяця
                'end' => date('Y-m-t', strtotime("-1 month")) // День в минулому місяці,
                // що відповідає сьогоднішьому. t представляє кількість днів у місяці.
            ]),
        ];
    }

    public function getAllOrdersByDate(string $date, string $key='date_create'): array {
        // Повертає масив усіх замовлень за певну дату з ключами cash (загальних прибуток від замовлень в масиві),
        // amount (кількісттю замовлень в масиві) і orders (сам масив замовлень)
        $date = self::validateDateTime($date);

        $result['cash'] = 0;
        foreach ($this->orders as $order) {
            if ($order[$key] === null || $order[$key] === '') continue;

            $order_date = self::validateDateTime($order[$key]);

            if ($order_date == $date) {
                $result['orders'][$order['id']] = $order;   // Масив замовлень
                $result['cash'] += $order['total_price'];   // Скільки усього грошеj в замовленнях
            }
        }

        if (isset($result['orders']))
            $result['amount'] = count($result['orders']);   // Кількість замовлень
        else $result['amount'] = 0;

        return $result;
    }

    public function getAllOrdersByAllPossibleDates(string $date): array {
        // Повертає статистку по замовленням за певний день у вигляді масиву
        $result = ['date' => $date];

        foreach (self::POSSIBLE_ORDER_ATTRIBUTES as $attr)
            $result[$attr] = $this->getAllOrdersByDate($date, $attr);

        return $result;
    }

    public function getAllOrdersForPeriod(array $period, string $key='date_create'): array {
        // Повертає масив замовлень за певний проміжок часу, по певному ключу бази даних

        $result['cash'] = 0; // Скільки усього грошеj в замовленнях
        $result['payment_type']['cash']['total_cash'] = 0;
        $result['payment_type']['card']['total_cash'] = 0;

        $period['start'] = DateTime::createFromFormat('Y-m-d H:i:s', $period['start'].' 00:00:00');
        $period['end'] = DateTime::createFromFormat('Y-m-d H:i:s', $period['end'].' 23:59:59');


        foreach ($this->orders as $order) {
            if ($order[$key] === null) continue;
            $date = self::validateDateTime($order[$key]);
            $date = DateTime::createFromFormat(self::DATE_FORMAT, $date);

            if ($date >= $period['start'] && $date <= $period['end']) { // Якщо дата, між діапазоном
                $result['orders'][$order['id']] = $order;   // Масив замовлень
                $result['cash'] += $order['total_price'];   // Скільки усього грошеj в замовленнях

                if ($order['type_of_payment'] == 'cash') {  // Якщо замовлення, оплачено готівкою
                    $result['payment_type']['cash']['orders'][$order['id']] = $order;
                    $result['payment_type']['cash']['total_cash'] += $order['total_price'];
                } else {    // Якщо замовлення, оплачено карткою
                    $result['payment_type']['card']['orders'][$order['id']] = $order;
                    $result['payment_type']['card']['total_cash'] += $order['total_price'];
                }
            }
        }

        $result['cash'] = round($result['cash'], 2); // Округлення всієї суми за замовлення до сотих
        $result['payment_type']['cash']['total_cash'] = round($result['payment_type']['cash']['total_cash'], 2);
        $result['payment_type']['card']['total_cash'] = round($result['payment_type']['card']['total_cash'], 2);

        if (isset($result['orders'])) {
            // Усі замовлення
            $result['amount'] = count($result['orders']);   // Кількість замовлень
            $result['averageCheck'] = round($result['cash'] / $result['amount'], 2); // Середній чек
        }
        else {
            $result['amount'] = 0;
            $result['averageCheck'] = 0;
        }

        if (isset($result['payment_type']['card']['orders'])) {
            // Замовлення, що оплачені карткою
            $result['payment_type']['card']['amount'] = count($result['payment_type']['card']['orders']);
        } else $result['payment_type']['card']['amount'] = 0;

        if (isset($result['payment_type']['cash']['orders'])) {
            // Замовлення, що оплачені готівкою
            $result['payment_type']['cash']['amount'] = count($result['payment_type']['cash']['orders']);
        } else $result['payment_type']['cash']['amount'] = 0;

        return $result;
    }

    public function getAllOrdersForPeriodByAllPossibleDates(array $period): array {
        // Повертає статистку по замовленням за певний проміжок часу у вигляді масиву
        $result['period'] = $period;

        foreach (self::POSSIBLE_ORDER_ATTRIBUTES as $attr)
            $result[$attr] = $this->getAllOrdersForPeriod($period, $attr);

        return $result;
    }

    public static function validateDateTime($date): string {
        // Форматує дату і час на просто дату
        if (!self::isValidDate($date)) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
            $date = $date->format(self::DATE_FORMAT);
        }

        return $date;
    }

    private static function isValidDate($date): bool {
        // Перевіряє, чи в правильному формату є дата
        $d = DateTime::createFromFormat(self::DATE_FORMAT, $date);
        return $d && $d->format(self::DATE_FORMAT) == $date;
    }

}