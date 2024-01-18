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
    private string $rights;     // Рівень прав користувача

    const COLUMNS = ['username', 'password', 'rights'];
    const TABLE = 'users';      // Назва таблиці, у якої зберігаються данні

    /**
     * @param string $username
     * @param string $password
     * @param string $rights
     * @param int $id
     * @param bool $checkCompliance
     */
    public function __construct(string $username, string $password, string $rights, int $id = -1,
                                bool $checkCompliance = true) {
        $this->repository = new Repository(self::TABLE, self::COLUMNS);

        if ($checkCompliance) {
            // checkCompliance - Чи потрібно проводити перевірку властивостей об'єкту при створенні
            $this->validateUsername($username, '__construct'); // Перевіряє, чи відповідає логін нормам
//            if (strlen($password) < 8)
//                throw new InvalidArgumentException('Конструктор User: Очікується, що довжина паролю >= 8 символів');
        }

        $this->id = $id;
        $this->username = $username;
        $this->password = $password; //password_hash($password, PASSWORD_DEFAULT);
        $this->rights = $rights;
    }

    public static function get(?int $id = null, ?string $name = null): User {
        // Повертає користувача у вигляді об'єкту
        $repository = new Repository(self::TABLE, self::COLUMNS);
        if ($name === null)
            $userValues = $repository->getRow($id);
        else $userValues = $repository->getRow($name, 'name');

        return new User(
            $userValues['username'],
            $userValues['password'],
            $userValues['rights'],
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
            $userValues['rights'],
            $userValues['id'],
            false // не превіряти властивості класу при стовренні
        );
    }

    public static function authorization(string $login, string $password): void {
        // Статичний метод для авторизації користувача

        global $router;
        try {
            // Чи існує користувач
            $user = User::getByLogin($login);
        } catch (Exception $e) {
            $_SESSION['error'] = '<b>Проблема під час входу в обліковий запис</b><br>' . $e->getMessage();
            $router->redirect('login');
        }

        if($password != $user->getPassword()) {
            $_SESSION['error'] = '<b>Проблема під час входу в обліковий запис</b><br>Неправильний пароль.';
            $router->redirect('login');
        }

        $_SESSION['user']['id'] = $user->getId();
        $router->redirect('profile');
    }

    public static function checkLogin(): ?User {
        // Метод, що перевіряє, чи залогінен користувач.
        // Якщо ні, то відбувається редірект.
        global $router;

        if ($router->url('login') !== "{$_SERVER['REQUEST_URI']}") {
            if (empty($_SESSION['user']['id'])) {
                $router->redirect('login');
                return null;
            } else return self::getLoginUser();
        } else return null;

    }

    public static function getLoginUser(): User {
        // Метод, що повертає об'єкт залогіненого користувача.
        return User::get($_SESSION['user']['id']);
    }

//    public static function isExist($id): bool {
//        $repository = new Repository(self::TABLE, self::COLUMNS);
//        return $repository->isThereRow('id', $id);
//    }

    public function getValues(): array {
        return [
            $this->username,            // username     varchar
            $this->password,            // password     varchar
            $this->rights               // rights       varchar
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
    private function validateUsername(string $username, string $errorPlace = 'validateUsername()'): void {
        error_log("validateUsername(string '$username', string '$errorPlace')");

        // Перевіряє, чи складається username тільки з латинських літер, і чи містить заборонені символи
        Utils::validateName($username, "$errorPlace"); // Utils. Викликає помилку, якщо довжина строки = 0
        if (!preg_match('/^[a-zA-Z]+$/', $username)) {
            error_log("Очікується, що $username буде містити тільки латинські літери.");
            throw new InvalidArgumentException("$errorPlace: Очікується, що $username буде містити тільки латинські літери.");
        }

        if ($this->repository->isThereRow('username', $username)) { // Перевірка, чи існує користувач
            error_log("Користувач з логіном $username вже існує.");
            throw new InvalidArgumentException("$errorPlace: Користувач з логіном $username вже існує.");
        }
    }

    public function getPassword(): string {
        // Повертає пароль користувача
        return $this->password;
    }
    public function setPassword(string $password): void {
        // Встановлює пароль користувачу
        if (strlen($password) < 8)
            throw new InvalidArgumentException('setPassword(string $password): Очікується, що довжина паролю >= 8 символів');
        $this->password = $password; // password_hash($password, PASSWORD_DEFAULT);
    }

    public function getUserRights(): string {
        // Повертає права користувача
        return $this->rights;
    }
    public function setRights(string $rights): void {
        // Встановлює права користувача
        $this->rights = $rights;
    }
}