import Repository as rep

import json
import pandas as pd
import os


def script():
    orders = rep.Repository('orders')
    customers = rep.Repository('customers')

    df = pd.read_csv('scripts/orders_for_import.csv')

    goods_csv = os.path.join(os.path.dirname(__file__), '..', 'settings', 'goods.csv')
    goods = pd.read_csv(goods_csv)  # csv файл з усіма продуктами

    invoice_config = os.path.join(os.path.dirname(__file__), '..', 'settings', 'config_invoice.json')
    with open(invoice_config, 'r') as file:
        invoice_config = json.load(file)  # актуальний конфіг квитанцій

    for row_index in range(len(df['Клієнт'])):
        productions_arr = []

        products = df['Вироби (назва - кількість - ціна - знижка)'][row_index].split(';')

        # Створення виробів замовлення
        for product in products:
            if len(product) == 0: break

            product = product.split(',')  # перетворення елементу виробу на масив

            try:
                goodID = int(goods[goods['name'] == product[0].replace(" ", "")]['id'].iloc[0])
            except IndexError as err:
                goodID = -1

            productions_arr.append(
                {
                    "note": "",
                    "price": float(product[2]),
                    "amount": int(product[1]),
                    "goodID": goodID,
                    "params": [],
                    "discount": int(product[3])
                }
            )

        productions = {'productions': productions_arr}

        # Знаходження/створення клієнта, що зробив замовлення
        customer = customers.get_row(df['Клієнт'][row_index], 'name')
        if customer is None:  # Якщо клієнт не існує, то він створюється
            customers.create_row(
                {
                    'name': df['Клієнт'][row_index]
                }
            )
            customer = customers.get_row(df['Клієнт'][row_index], 'name')

        # Створення нового рядку 
        orders.create_row(
            {
                'id_customer': customer[0],  # id користувача
                'id_user': 1,
                'date_create': df['Дата створення замовлення'][row_index],
                'date_end': df['Дата закриття замовлення'][row_index],
                'total_price': int(df['Загальна ціна'][row_index]),
                'productions': json.dumps(productions),
                'is_paid': int(df['Чи оплачено'][row_index]),
                'is_completed': int(df['Чи закрите'][row_index]),
                'date_payment': df['Дата оплати'][row_index],
                'date_closing': df['Дата закриття'][row_index],
                'date_last_update': None,
                'settings': json.dumps(invoice_config),
            }
        )

    orders.close_connect()
    customers.close_connect()

    return 'Імпорт виконаний'


if __name__ == "__main__":
    script()
