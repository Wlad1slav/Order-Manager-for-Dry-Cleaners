<div>
    <h2>Імпорт клієнтів</h2>
    <b> :: </b>
    <a href="/settings/templates/customers_template.csv" class="cta-text">Шаблон для імпорту</a>
    <b> :: </b>
    <a onclick="convertAndDownloadTable('customers')" href="javascript:void(0);" class="cta-text">Експортувати</a>
    <b> :: </b>
    <form action="<?php echo $router->url('customersImport') ?>" method="post" enctype="multipart/form-data" id="import">
        <input type="file" name="fileToUpload" id="fileToUpload" accept=".csv">
        <input type="submit" value="Завантажити" name="submit">
    </form>
    <!--    <h3>Обережно!</h3>-->
    <p><span class="warning">(!)</span> Після початку імпорту файлу не зачиняйте сторінку! Імпорт може зайняти деякий час.</p>
    <p><span class="warning">(!)</span> Якщо у вас винекне помилка <b>при іморті</b>, то вас перенаправить на іншу сторінку. В самому низу буде зазначено, в якому саме рядку сталася помилка.</p>
    <p><span class="warning">(!)</span> Рекомендуємо завантажувати не більше 1000 рядків за раз! Інакше винекне помилка, через перенавантаження скрипту.<br></p>
    <p>Ви можете вручну змінити налаштування у файлі <b>forms/customerUpload.php</b>. Визначте скільки секунд ви хочете, щоб обраблявся скрипт `set_time_limit(60)`.</p>
    <p><i>520 рядків = ~30 секунд.</i></p>
    <p><span class="warning">(!)</span> Не забувайте о лімітах:</p>
    <ul>
        <li>Ім'я клієнта не може пустим і перевищувати 70 символів</li>
        <li>Номер телефону клієнта не може перевищувати 20 символів</li>
        <li>Знижка клієнта не може бути пустою, меньше 0 і більше 99</li>
        <li>Клетинка зі знижкою клієнта може містити тільки числове значення</li>
    </ul>
    <p><i>Налаштувати ліміти ви можете у файлі <b>settings/config.php</b></i></p>
</div>