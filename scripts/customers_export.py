import Repository as rep

import pandas as pd


def script():
    print('The script is running')

    customers = rep.Repository('customers')
    customers_dic = {
        'id': [],
        'name': [],
        'phone': [],
        'discount': [],
        'advertising_company': [],
    }

    for customer in customers.get_all():
        customers_dic['id'].append(customer[0])
        customers_dic['name'].append(customer[1])
        customers_dic['phone'].append(customer[2])
        customers_dic['discount'].append(customer[3])
        customers_dic['advertising_company'].append(customer[4])

    # Створення DataFrame
    df = pd.DataFrame(customers_dic)

    # Запис DataFrame у файл CSV
    df.to_csv('scripts/customers_exported.csv')

    customers.close_connect()


if __name__ == "__main__":
    script()
