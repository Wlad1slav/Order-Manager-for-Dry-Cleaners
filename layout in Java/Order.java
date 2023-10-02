import java.lang.reflect.Array;
import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

public class Order {
    private int id; // Індіфікатор замовлення
    private Client client; // Клієнт, що зробив замовлення
    private User creator; // Сотрудник, що створив замовлення
    private LocalDateTime date_create; // Дата створення замовлення
    private LocalDateTime date_end; // Дедлайн замовлення
    private boolean isPaid; // Чи оплачено замовлення
    private boolean isCompleted; // Чи виконано/закрите замовлення
    private float totalPrice; // Загальна ціна замовлення
    private Production[] productions; // Масив виробів

    public Order(int id, Client client, User creator, boolean isPaid, boolean isCompleted, Production[] productions) {
        this.id = id;
        this.client = client;
        this.creator = creator;
        this.date_create = LocalDateTime.now(); // Встановлює поточну дату та час
        this.date_end = LocalDateTime.now().plusDays(3); // Встновлює дату, до якої додано ще 3 днів
        this.isPaid = isPaid;
        this.isCompleted = isCompleted;
        this.totalPrice = Utils.greaterOrEqualZero(countTotalPrice(productions));
        if (productions.length > 0) // Якщо довжина виробу меньше одного елементу, то виникає помилка
            this.productions = productions;
        else
            throw new IllegalArgumentException("Order конструктор: Масив виробів не може бути порожнім");
    }

    public int getId() {
        // Повертає значення індіфікатору замовлення
        return id;
    }

    public LocalDateTime getDate_create() {
        // Повертає значення дати створення замовлення
        return date_create;
    }

    public LocalDateTime getDate_end() {
        // Повертає значення дати дедлайну замовлення
        return date_end;
    }
    public void setDate_end(LocalDateTime date_end) {
        this.date_end = date_end;
    }

    public boolean isPaid() {
        // Повертає, чи оплачено замовлення
        return isPaid;
    }
    public void setPaid(boolean paid) {
        // Змінює значення isPaid
        isPaid = paid;
    }

    public boolean isCompleted() {
        // Повертає, чи виконане замовлення
        return isCompleted;
    }
    public void setCompleted(boolean completed) {
        // Змінює значення isCompleted
        isCompleted = completed;
    }

    public void switchPaidStatus() {
        // Переключає статус оплати замовлення
        isPaid = !isPaid;
    }
    public void switchCompleteStatus() {
        // Переключає статус готовності замовлення
        isCompleted = !isCompleted;
    }

    public float getTotalPrice() {
        // Повертає повну ціну за замовлення
        return totalPrice;
    }
    public void setTotalPrice(float totalPrice) {
        // Змінює значення загальной ціни
        this.totalPrice = Utils.greaterOrEqualZero(totalPrice);
    }
    private float countTotalPrice(Production[] productions) {
        // Рахує сумму за усі замовлення
        float totalPrice = 0;
        if (productions != null) {
            for (Production production : productions) // Проходить по усім переданим виробам
                totalPrice += production.getPrice();
        }

        return totalPrice;
    }

    public Client getClient() {
        // Повертає клієнта замовлення
        return client;
    }
    public void setClient(Client client) {
        // Встановлює клієнта замовлення
        this.client = client;
    }

    public User getCreator() {
        // Повертає користувача, що створив замовлення
        return creator;
    }

    public Production[] getProductions() {
        // Повертає масив составних замовлення
        return productions;
    }
    public void setProductions(Production[] productions) {
        // Встановлює составні замовлення
        this.productions = productions;
    }
    public HashMap<Byte, HashMap> getComponents() {
        // Повертає словник з усіма данними о компонентах (виробах) замовлення

        HashMap<Byte, HashMap> components = new HashMap<>();
        byte num = 0;
        for (Production production : productions) {
            num++;
            HashMap<String, String> params = new HashMap<>();

            params.put("Товар: ", production.getGoods().getName());
            params.put("Кількість: ", production.getAmountString());
            params.put("Ціна: ", production.getPriceString());
            params.put("Ціна (за шт.): ", production.getGoods().getPriceString());
            params.put("Нотатки", production.getNote());

            components.put(num, params);
        }

        return components;
    }
}
