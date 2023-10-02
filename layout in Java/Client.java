public class Client {
    private int id; // Індіфікатор замовника
    private String fullName; // Ім'я замовника
    private String phoneNumber; // Номер телефону замовника
    private String advertisingCampaign; // Звідки замовник дізнався о компанії
    private float discount; // Знижка, що має замовник

    public Client(int id, String fullName, String phoneNumber, String advertisingCampaign, float discount) {
        this.id = id;
        if (!fullName.isEmpty())
            this.fullName = fullName;
        else
            throw new IllegalArgumentException("Client конструктор: Строка ім'я клієнта не може бути пустою");
        this.phoneNumber = phoneNumber;
        this.advertisingCampaign = advertisingCampaign;
        this.discount = Utils.greaterOrEqualZero(discount);
    }

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
        if (!fullName.isEmpty())
            this.fullName = fullName;
        else // Якщо довжина ім'я = 0, то виникає помилка
            throw new IllegalArgumentException("setFullName(String fullName) - Строка ім'я клієнта не може бути пустою");
    }

    public String getPhoneNumber() {
        // Повертає номер телефону замовника
        return phoneNumber;
    }
    public void setPhoneNumber(String phoneNumber) {
        // Встановлює значення номеру телефону замавнику
        this.phoneNumber = phoneNumber;
    }
    public String callLink() {
        // Повертає посилання для дзвонку по номеру телефона
        if (!phoneNumber.isEmpty())
            return "tel:" + getPhoneNumber();
        else
            throw new IllegalArgumentException("callLink() - Для того, щоб отримати посилання для дзвінку, потрібно ввести номер телефону клієнта");
    }

    public String getAdvertisingCampaign() {
        // Повертає рекламну кампанію замовника
        return advertisingCampaign;
    }

    public float getDiscount() {
        // Повертає значення знижки у замовника
        return discount;
    }

    public void setDiscount(float discount) {
        // Змінює значення знижки у замовника
        this.discount = Utils.greaterOrEqualZero(discount);
    }
}
