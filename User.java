public class User {
    private int id; // Індіфікатор користувача
    private String username; // Логін замовника
    private String password; // Пароль замовника
    private Rights rights; // Рівень прав користувача

    public User(int id, String username, String password, Rights rights) {
        this.id = id;

        if ((username.length() >= 8) && username.matches("[a-zA-Z]+"))
            this.username = username;
        else throw new IllegalArgumentException("Username користувача занадто маленький (мін. 8 символів)");

        if (password.length() >= 8)
            this.password = password;
        else throw new IllegalArgumentException("Пароль користувача занадто маленький (мін. 8 символів)");

        this.rights = rights;
    }

    public int getId() {
        // Повертає індіфікатор користувача
        return id;
    }

    public String getUsername() {
        // Повертає ім'я користувача
        return username;
    }
    public void setUsername(String username) {
        // Змінює логін користувача
        if (username.matches("[a-zA-Z]+") // Якщо логін містить тільки латинські літери
        && username.length() > 8) // і довже 0 символів
            this.username = username; // змінюється логін
        else // В противному випадку
            throw new IllegalArgumentException("setUsername(String username) - помилка в логіні користувача. Він повинен буте довже 8 літер і містити тільки ластинськи літери");
    }

    public String getPassword() {
        // Повертає пароль користувача
        return password;
    }
    public void setPassword(String password) {
        if (password.length() > 8)
            this.password = password;
        else // Якщо довжина паролю = 0, то виникає помилка
            throw new IllegalArgumentException("setPassword(String password) - помилка в паролі користувача. Він повинен буте довже 8 літер.");
    }

    public Rights getRights() {
        // Повертає рівень прав користувача
        return rights;
    }
    public void setRights(Rights rights) {
        // Змінює рівень прав користувача
        this.rights = rights;
    }
}
