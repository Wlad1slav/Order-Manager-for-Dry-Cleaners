public class Client {
    private int id; // Індіфікатор замовника
    private String fullName; // Ім'я замовника
    private String phoneNumber; // Номер телефону замовника
    private String advertisingCampaign; // Звідки замовник дізнався о компанії
    private String date_create; // Дата створення замовника
    private float discount; // Знижка, що має замовник

    public int getId() {
        // Повртає індіфікатор замовника
        return id;
    }

    public String getFullName() {
        // Повертає повне ім'я замовника
        return fullName;
    }
    public void setFullName(String fullName) {
        // Встановлює ім'я замовника
        if (fullName.length() != 0)
            this.fullName = fullName;
        else // Якщо довжина ім'я = 0, то виникає помилка
            throw new IllegalArgumentException("Invalid argument provided");
    }

    public String getPhoneNumber() {
        // Повертає номер телефону замовника
        return phoneNumber;
    }
    public void setPhoneNumber(String phoneNumber) {
        // Встановлює значення номеру телефону замавнику
        if (phoneNumber.length() != 0)
            this.phoneNumber = phoneNumber;
        else // Якщо довжина номеру телефону = 0, то виникає помилка
            throw new IllegalArgumentException("Invalid argument provided");
    }
    public String callLink() {
        // Повертає посилання для дзвонку по номеру телефона
        return "tel:" + getPhoneNumber();
    }

    public String getAdvertisingCampaign() {
        // Повертає рекламну кампанію замовника
        return advertisingCampaign;
    }

    public String getDate_create() {
        // Повертає дату створення замовника
        return date_create;
    }

    public float getDiscount() {
        // Повертає значення знижки у замовника
        return discount;
    }

    public void setDiscount(float discount) {
        // Змінює значення знижки у замовника
        if (discount >= 0)
            this.discount = discount;
        else this.discount = 0;
    }
}
