public class User {
    private int id; // Індіфікатор користувача
    private String username; // Логін замовника
    private String password; // Пароль замовника
    private Rights rights; // Рівень прав користувача

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
        if (username.matches("[a-zA-Z]*") // Якщо логін містить тільки латинські літери
        && username.length() != 0) // і довже 0 символів
            this.username = username; // змінюється логін
        else // В противному випадку
            throw new IllegalArgumentException("Invalid argument provided"); // виникає помилка
    }

    public String getPassword() {
        // Повертає пароль користувача
        return password;
    }
    public void setPassword(String password) {
        if (password.length() != 0)
            this.password = password;
        else // Якщо довжина паролю = 0, то виникає помилка
            throw new IllegalArgumentException("Invalid argument provided");
    }

    public Rights getRights() {
        // Повертає рівень прав користувача
        return rights;
    }
}
