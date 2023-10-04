<?php

class User {
    private int $id; // Ідентифікатор користувача
    private string $username; // Логін замовника
    private string $password; // Пароль замовника
    private Rights $rights; // Рівень прав користувача

    private Utils $utils;

    /**
     * @param int $id
     * @param string $username
     * @param string $password
     * @param Rights $rights
     */
    public function __construct(int $id, string $username, string $password, Rights $rights) {
        $this->utils = new Utils(); // додаткові утіліти

        $this->id = $id;
        $this->validateUsername($username); // Перевіряє, чи відповідає логін нормам
        $this->username = $username;
        if (strlen($password) < 8)
            throw new InvalidArgumentException('Конструктор User: Очікується, що довжина паролю >= 8 символів');
        $this->password = $password;
        $this->rights = $rights;
    }

    public function getId(): int {
        // Повертає Ідентифікатор користувача
        return $this->id;
    }

    public function getUsername(): string {
        // Повертає логін користувача
        return $this->username;
    }
    public function setUsername(string $username): void {
        // Встановлює ім'я користувача
        $this->validateUsername($username); // Перевіряє, чи відповідає логін нормам
        $this->username = $username;
    }
    private function validateUsername(string $username): void {
        // Перевіряє, чи складається username тільки з латинських літер, і чи містить заборонені символи
        $this->utils->validateName($username, "validateUsername(string $username)"); // Utils. Викликає помилку, якщо довжина строки = 0
        if (!preg_match('/^[a-zA-Z]+$/', $username))
            throw new InvalidArgumentException('validateUsername(string $username): Очікується, що username буде містити тільки латинські літери');
    }

    public function getPassword(): string {
        // Повертає пароль користувача
        return $this->password;
    }
    public function setPassword(string $password): void {
        // Встановлює пароль користувачу
        if (strlen($password) <= 8)
            throw new InvalidArgumentException('setPassword(string $password): Очікується, що довжина паролю >= 8 символів');
        $this->password = $password;
    }

    public function getRights(): Rights {
        // Повертає права користувача
        return $this->rights;
    }
    public function setRights(Rights $rights): void {
        // Встановлює права користувача
        $this->rights = $rights;
    }

}