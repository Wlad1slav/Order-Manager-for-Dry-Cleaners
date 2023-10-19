// Отримання даних о клієнті
const customerNameInput = document.getElementById('customer-name');
const orderDiscountInput = document.getElementById('order-discount');
const customersDatalist = document.getElementById('customers');

customerNameInput.addEventListener('input', function() {
    // Встановлення даних о клієнті в поля форми

    // Перевірка, чи є така опція в datalist
    const option = [...customersDatalist.options].find(opt => opt.value === customerNameInput.value);

    if (option) {
        orderDiscountInput.value = option.getAttribute('data-discount');
    } else {
        orderDiscountInput.value = ''; // очищаємо поле знижки, якщо клієнт не вибраний
    }
});

function updatePrice(i, pricePerProductStatic=false) {
    // Функція оновлення ціни за виріб
    const goodNameInput = document.getElementById(`good-name-${i}`);
    const amountInput = document.getElementById(`amount-${i}`);
    const priceInput = document.getElementById(`price-${i}`);
    const pricePerGoodInput = document.getElementById(`price-per-one-${i}`);
    const goodsDatalist = document.getElementById(`goods-${i}`);

    // Перевірка, чи є така опція в datalist
    const option = [...goodsDatalist.options].find(opt => opt.value === goodNameInput.value);

    if (!pricePerProductStatic && option) // при зміні кількісті товару, ціна за шт. статична.
    // Зроблено для того, щоб можна було встановлювати кастомну ціна за шт.
        pricePerGoodInput.value = option.getAttribute('data-price');
    priceInput.value = pricePerGoodInput.value * amountInput.value;

    // Оновлення поля загальной ціни замовлення
    totalPriceArr[i-1] = parseFloat(priceInput.value);
    console.log(totalPriceArr);
    updateTotalPrice();
}

var totalPriceArr = [];

function updateTotalPrice() {
    // Оновлення поля загальной ціни замовлення
    const totalPriceText = document.getElementById('total-price');
    let sum = 0;
    for (let i = 0; i < totalPriceArr.length; i++) {
        sum += totalPriceArr[i];
    }
    console.log(sum);
    totalPriceText.textContent = sum;
}


// Отримання даних о продукті
for (let i = 1; i <= 5; i++) {
    // Отримання даних о продукті
    const goodNameInput = document.getElementById(`good-name-${i}`);
    const amountInput = document.getElementById(`amount-${i}`);
    const pricePerGoodInput = document.getElementById(`price-per-one-${i}`);

    goodNameInput.addEventListener('input', function() {
        // Відстеження вибіру продукту
        updatePrice(i);
    });

    amountInput.addEventListener('input', function() {
        // Відстеження зміни кількості продукту
        updatePrice(i, true);
    });

    pricePerGoodInput.addEventListener('input', function() {
        // Відстеження зміни ціни продукту за штуку
        updatePrice(i, true);
    });
}



