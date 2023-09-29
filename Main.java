import java.util.Arrays;
import java.util.HashMap;

public class Main {
    public static void main(String[] args) {
        // ТОВАРИ
        Goods good1 = new Goods(1, "яйце", 17.0F);
        Goods good2 = new Goods(2, "молоко", 32.5F);

        // ВИРОБИ
        HashMap<String, String> params = new HashMap<>();
        params.put("example", "example");
        Production[] productions = new Production[] {
                new Production(10, "білі", params, good1),
                new Production(2, "2% жиру", params, good2),
                new Production(1, "жовте", params, good1),
        };

        // РІВЕНЬ ПРАВ
        Rights root = new Rights(1, "ROOT", params);

        // КОРИСТУВАЧ
        User vlad = new User(1, "Vladyslav", "12345678", root);

        // КЛІЄНТ
        Client oleksandr = new Client(1, "Oleksandr Oleksandroviczh Oleksandrov", "+380(00)000-000", "Оболонь", 50.0F);

        // ЗАМОВЛЕННЯ
        Order order = new Order(1, oleksandr, vlad, false, false, productions);


        System.out.println("Замовлення: " + order);
        System.out.println("ID: " + order.getId());
        System.out.println("Дата створення: " + order.getDate_create());
        System.out.println("Дата дедлайну: " + order.getDate_end());
        System.out.println("Замовник: " + order.getClient());
        System.out.println("Хто створив замовлення: " + order.getCreator());
        System.out.println("Составні замовлення: " + Arrays.toString(order.getProductions()));
        System.out.println("Загальна ціна: " + order.getTotalPrice());

        System.out.println("Виорби:");
        System.out.println(order.getComponents());

    }
}

