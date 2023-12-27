import Repository as rep

import pandas as pd
import json
import os


def script():
    print('The script is running')
    orders = rep.Repository('orders')

    customers = rep.Repository('customers')
    customers_dic = customers.get_all_in_dic()
    customers.close_connect()

    goods_csv = os.path.join(os.path.dirname(__file__), '..', 'settings', 'goods.csv')
    goods = pd.read_csv(goods_csv)  # csv файл з усіма продуктами

    orders_dic = {  # Колонки таблиці
        'id': [],   # 0
        'Клієнт': [],  # 1
        'Дата створення замовлення': [],  # 3
        'Дата дедлайну замовлення': [],  # 4
        'Загальна ціна': [],  # 5
        'Вироби (назва - кількість - ціна - знижка)': [],  # 6
        'Чи оплачено': [],  # 7
        'Чи закрите': [],  # 8
        'Дата оплати': [],  # 9
        'Дата закриття': [],  # 10
    }
    for order in orders.get_all():  # отримання усіх замовлень і проходка по ним
        orders_dic['id'].append(order[0])
        orders_dic['Клієнт'].append(customers_dic[order[1]][1])  # order[1] - Ключ, id клієнта. [1] - друга колонка з ім'ям клієнта
        orders_dic['Дата створення замовлення'].append(order[3])
        orders_dic['Дата дедлайну замовлення'].append(order[4])
        orders_dic['Загальна ціна'].append(order[5])

        products = ''  # Вироби
        for product in json.loads(order[6])['productions']:  # Масив словників виробів
            good = goods.loc[goods['id'] == product['goodID']]
            products += f"{good['name'].values[0]}, {product['amount']}, {product['price']}, {product['discount']};"
        orders_dic['Вироби (назва - кількість - ціна - знижка)'].append(products)

        orders_dic['Чи оплачено'].append(order[7])
        orders_dic['Чи закрите'].append(order[8])
        orders_dic['Дата оплати'].append(order[9])
        orders_dic['Дата закриття'].append(order[10])

    # Створення DataFrame
    df = pd.DataFrame(orders_dic)

    # Запис DataFrame у файл CSV
    df.to_csv('scripts/orders_exported.csv')

    orders.close_connect()


if __name__ == "__main__":
    script()
