import java.util.HashMap;

public class Rights {
    private int id; // Індіфікатор рівня прав
    private String slug; // Найменування рівня прав
    private HashMap<String, String> perms = new HashMap<>(); // Словник усіх прав користувача // словник.put("книга", "book");

    public Rights(int id, String slug, HashMap<String, String> perms) {
        this.id = id;
        if (slug.matches("[a-zA-Z]+") && !slug.isEmpty())
            this.slug = slug;
        else
            throw new IllegalArgumentException("Rights конструктор: Назва рівня прав неповинна бути пустою і містити нелатинськи символи");
        if (perms != null)
            this.perms = perms;
        else
            throw new IllegalArgumentException("Rights конструктор: Словник повноважень не може бути рівним null");
    }

    public int getId() {
        // Повертає індіфікатор рівня прав
        return id;
    }

    public String getSlug() {
        // Повертає найменування рівня прав
        return slug;
    }
    public void setSlug(String slug) {
        // Змінює найменування рівня прав
        // Якщо слаг містить тільки латинські літери
        if (slug.matches("[a-zA-Z]+") && !slug.isEmpty()) // і довже 0 символів
            this.slug = slug; // змінює найменування рівня прав
        else // В противному випадку
            throw new IllegalArgumentException("setSlug(String slug) - Назва рівня прав неповинна бути пустою і містити нелатинськи символи");
    }

    public HashMap<String, String> getPerms() {
        // Повертає список усіх повноваженнь рівня прав
        return perms;
    }
    public void setPerms(HashMap<String, String> perms) {
        // Змінює список повноважень рівня прав
        if (perms != null)
            this.perms = perms;
        else
            throw new IllegalArgumentException("setPerms(HashMap<String, String> perms) - Словник повноважень не може бути рівним null");
    }
}
