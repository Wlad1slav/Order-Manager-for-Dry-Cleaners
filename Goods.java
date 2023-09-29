public class Goods {
    private int id; // Індіфікатор продукту
    private String name; // Назва продукту
    private float price; // Ціна за 1 шт. продукту

    public Goods(int id, String name, float price) {
        this.id = id;
        if (name != null && !name.isEmpty())
            this.name = name;
        else
            throw new IllegalArgumentException("Goods конструктор: Строка ім'я не може бути пустою");
        this.price = Utils.greaterOrEqualZero(price);
    }

    public int getId() {
        // Повертає індіфікатор продукту
        return id;
    }

    public String getName() {
        // Повертає назву продукту
        return name;
    }
    public void setName(String name) {
        // Змінює назву продукту
        if (name != null && !name.isEmpty())
            this.name = name;
        else
            throw new IllegalArgumentException("setName(String name) - Строка ім'я не може бути пустою");
    }

    public float getPrice() {
        // Повертає ціна за 1 шт. продукту
        return price;
    }
    public String getPriceString() {
        // Повертає строку з ціной за 1 шт. продукту
        return Float.toString(price) + " UAH";
    }
    public void setPrice(float price) {
        // Змінює ціну за 1 шт. продукту
        this.price = Utils.greaterOrEqualZero((price));
    }
}
