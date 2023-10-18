function redirectTo(url) {
    // Редірект на іншу сторінку
    window.location.href = url;
}

function confirmAndDelete(id, table) {
    // Підтвердження видалення
    const isConfirmed = confirm("Ви впевненні, що хочете видалити об'єкт з ID: " + id + "?");

    if (isConfirmed) {
        // Якщо підтверджено, відбувається редірект до точки видалення з ідентифікатором об'єкту
        window.location.href = table + '/delete?id=' + id;
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Перевіряє, чи пусті поля для CSS стилів
    var inputs = document.querySelectorAll('input');

    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            if (this.value) {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });
    });
});
