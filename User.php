<?php
require_once 'RepositoryTraits.php';
require_once 'Repository.php';
require_once 'Rights.php';
require_once 'Utils.php';

class User {
    use RepositoryTraits;

    private int $id;            // Ідентифікатор користувача
    private string $username;   // Логін замовника
    private string $password;   // Пароль замовника
    private Rights $rights;     // Рівень прав користувача

    const COLUMNS = ['username', 'password', 'id_rights'];
    const TABLE = 'users';      // Назва таблиці, у якої зберігаються данні

    /**
     * @param string $username
     * @param string $password
     * @param Rights $rights
     * @param int $id
     * @param bool $checkCompliance
     */
    public function __construct(string $username, string $password, Rights $rights, int $id = -1, $checkCompliance = true) {
        $this->repository = new Repository(self::TABLE, self::COLUMNS);

        if ($checkCompliance) {
            // checkCompliance - Чи потрібно проводити перевірку властивостей об'єкту при створенні
            $this->validateUsername($username); // Перевіряє, чи відповідає логін нормам
            if (strlen($password) < 8)
                throw new InvalidArgumentException('Конструктор User: Очікується, що довжина паролю >= 8 символів');
        }

        $this->id = $id;
        $this->username = $username;
        $this->password = $password; //password_hash($password, PASSWORD_DEFAULT);
        $this->rights = $rights;
    }

    public static function get($id): User {
        // Повертає користувача у вигляді об'єкту
        $repository = new Repository(self::TABLE, self::COLUMNS);
        $userValues = $repository->getRow($id);
        return new User(
            $userValues['username'],
            $userValues['password'],
            User::getRight($userValues['id_rights']),
            $userValues['id'],
            false // не превіряти властивості класу при стовренні
        );
    }

    public static function getByLogin($login): User {
        // Повертає користувача у вигляді об'єкту
        $repository = new Repository(self::TABLE, self::COLUMNS);
        $userValues = $repository->getRow($login, 'username');
        return new User(
            $userValues['username'],
            $userValues['password'],
            User::getRight($userValues['id_rights']),
            $userValues['id'],
            false // не превіряти властивості класу при стовренні
        );
    }

    public static function authorization(string $login, string $password): void {
        // Статичний метод для авторизації користувача

        try {
            // Чи існує користувач
            $user = User::getByLogin($login);
        } catch (Exception $e) {
            $_SESSION['error'] = '<b>Проблема під час входу в обліковий запис</b><br>' . $e->getMessage();
            Router::redirect('/login');
        }

        if($password != $user->getPassword()) {
            $_SESSION['error'] = '<b>Проблема під час входу в обліковий запис</b><br>Неправильний пароль.';
            Router::redirect('/login');
        }

        $_SESSION['user']['id'] = $user->getId();
        Router::redirect('/profile');
    }

    public static function getRight(int $id): Rights {
        $rights = require 'settings/rights_list.php';
        return $rights[$id-1];
    }

    public function getValues(): array {
        return [
            $this->username,            // username     varchar
            $this->password,            // password     varchar
            $this->rights->getId()      // id_rights    int
        ];
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
        Utils::validateName($username, "validateUsername(string $username)"); // Utils. Викликає помилку, якщо довжина строки = 0
        if (!preg_match('/^[a-zA-Z]+$/', $username))
            throw new InvalidArgumentException("validateUsername(string $username): Очікується, що username буде містити тільки латинські літери");

        if ($this->repository->isThereRow('username', $username)) // Перевірка, чи існує користувач
            throw new InvalidArgumentException("validateUsername(string $username): Користувач з логіном $username вже існує.");
    }

    public function getPassword(): string {
        // Повертає пароль користувача
        return $this->password;
    }
    public function setPassword(string $password): void {
        // Встановлює пароль користувачу
        if (strlen($password) <= 8)
            throw new InvalidArgumentException('setPassword(string $password): Очікується, що довжина паролю >= 8 символів');
        $this->password = $password; // password_hash($password, PASSWORD_DEFAULT);
    }

    public function getUserRights(): Rights {
        // Повертає права користувача
        return $this->rights;
    }
    public function setRights(Rights $rights): void {
        // Встановлює права користувача
        $this->rights = $rights;
    }
}