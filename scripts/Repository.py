import mysql.connector
import json
import os


class Repository:
    config_path = os.path.join(os.path.dirname(__file__), '..', 'settings', 'config_db.json')

    def __init__(self, table):
        # Отримання параметрів підключення
        with open(self.config_path, 'r') as file:
            data = json.load(file)
        # Встановлення параметрів підключення
        config = {
            'host': data['host'],
            'user': data['user'],
            'password': data['pass'],
            'database': data['dbname']
        }

        # Підключення до бази даних
        self.conn = self.connect(config)

        self.table = table # Таблиця, з якою будуть проводитися маніпуляції


    def connect(self, config):
        # Створення з'єднання
        try:
            connect = mysql.connector.connect(**config)
            if connect.is_connected():
                print('Підключено до бази даних')
                return connect

        except mysql.connector.Error as err:
            print(f'Помилка: {err}')
        
    def close_connect(self):
        # Закриття з'єднання
        if self.conn.is_connected():
            self.conn.close()
            print('З\'єднання закрито')

    def get_row(self, value, column = 'id'):
        # Метод для отримання змісту рядку з бд

        cursor = self.conn.cursor()
        try:
            query = f'SELECT * FROM {self.table} WHERE {column} = %s' # SQL запит для отримання рядка
            cursor.execute(query, (value,)) # встановлення value в SQL запит через метод execute (захист від SQL ін'єкції)
            row = cursor.fetchone() # Виконання SQL запиту
            return row
        except mysql.connector.Error as err:
            print(f'Помилка запиту: {err}')
            return False
        finally:
            cursor.close()

    def create_row(self, data):
        # Метод, для додавання рядку в бд

        columns = ', '.join([f'`{column}`' for column in data.keys()]) # Отримання колонок, в які треба додати данні
        placeholders = ', '.join(['%s' for _ in data.values()]) # Отримання даних, які треба додати в колонки

        query = f'INSERT INTO `{self.table}` ({columns}) VALUES ({placeholders})' # SQL запит для створення рядку
    
        cursor = self.conn.cursor()

        try:
            cursor.execute(query, tuple(data.values())) # Виконання SQL запиту
            self.conn.commit() # Збереження результатів
            return True
        except mysql.connector.Error as err:
            print(f'Помилка запиту: {err}')
            return False
        finally:
            cursor.close()
