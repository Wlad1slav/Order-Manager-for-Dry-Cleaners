import java.util.HashMap;

public class Production {
    private int amount; // Кількість шт.
    private float price; // Ціна за виріб
    private String note; // Примітки щодо товару
    private HashMap<String, String> params; // Словник додоткових параметрыв виробу
    private Goods goods; // Продукт виробу

    public Production(int amount, String note, HashMap<String, String> params, Goods goods) {
        if (goods == null) {
            throw new IllegalArgumentException("Production конструктор: Продукт виробу не може дорівнюватися null");
        }
        this.amount = Utils.greaterOrEqualZero(amount);
        this.price = goods.getPrice() * amount;
        this.note = note;
        this.params = params;
        this.goods = goods;
    }

    public int getAmount() {
        // Повертає кількість шт. в виробу
        return amount;
    }
    public String getAmountString() {
        // Повертає строку кількості шт. в виробу
        return Integer.toString(amount) + " шт.";
    }
    private void recalculatePrice() {
        // Щоразу, коли кількість або товар виробу оновлюються, ціна перераховуюється
        this.price = goods.getPrice() * amount;
    }
    public void setAmount(int amount) {
        // Змінює кількість шт. у виробу
        this.amount = Utils.greaterOrEqualZero(amount);
        recalculatePrice();
    }

    public float getPrice() {
        // Повертає ціну за виріб
        return price;
    }
    public String getPriceString() {
        // Повертає строку ціни за виріб
        return Float.toString(price) + " UAH";
    }
    public void setPrice(float price) {
        // Встановлює ціну за виріб
        this.price = Utils.greaterOrEqualZero(price);
    }

    public String getNote() {
        // Повертає помітки по виробу
        return note;
    }
    public void setNote(String note) {
        // Встановлює помітки по виробу
        this.note = note;
    }

    public HashMap<String, String> getParams() {
        // Повертає кастомні параметри виробу
        return params;
    }
    public void setParams(HashMap<String, String> params) {
        // Встановлює кастомні параметри к виробу
        this.params = params;
    }

    public Goods getGoods() {
        // Повертає продукт виробу
        return goods;
    }
    public void setGoods(Goods goods) {
        // Встановлює продукт виробу
        if (goods == null)
            throw new IllegalArgumentException("setGoods(Goods goods) - Продукт виробу не може дорівнюватися null");
        this.goods = goods;
        recalculatePrice();
    }
}
