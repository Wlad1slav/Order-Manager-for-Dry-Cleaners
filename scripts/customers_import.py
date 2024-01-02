import Repository as rep
from Repository import convert_types

import pandas as pd


def script():
    customers = rep.Repository('customers')

    df = pd.read_csv('scripts/customers_for_import.csv')

    for _, customer in df.iterrows():
        customer_data = convert_types(customer.to_dict())  # Перетворення типів перед створенням рядка в бд
        customers.create_row(customer_data)

    customers.close_connect()

    return 'Import completed'


if __name__ == "__main__":
    script()
