public class Order {
    private int id; // Індіфікатор замовлення
    private Client client; // Клієнт, що зробив замовлення
    private User creator; // Сотрудник, що створив замовлення
    private String date_create; // Дата створення замовлення
    private String date_end; // Дедлайн замовлення
    private boolean isPaid; // Чи оплачено замовлення
    private boolean isCompleted; // Чи виконано/закрите замовлення
    private float totalPrice; // Загальна ціна замовлення
    private Product[] products; // Масив виробів

    public int getId() {
        // Повертає значення індіфікатору замовлення
        return id;
    }

    public String getDate_create() {
        // Повертає значення дати створення замовлення
        return date_create;
    }

    public String getDate_end() {
        // Повертає значення дати дедлайну замовлення
        return date_end;
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

    public float getTotalPrice() {
        // Повертає повну ціну за замовлення
        return totalPrice;
    }
    public void setTotalPrice(float totalPrice) {
        // Змінює значення загальной ціни
        if (totalPrice >= 0)
            this.totalPrice = totalPrice;
        else this.totalPrice = 0;
    }
}
