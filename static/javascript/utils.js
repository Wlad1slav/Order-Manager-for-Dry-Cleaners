function redirectTo(url) {
    // Редірект на іншу сторінку
    window.location.href = url;
}

function confirmAndDelete(id) {
    // Підтвердження видалення
    const isConfirmed = confirm("Ви впевненні, що хочете видалити об'єкт з ID: " + id + "?");

    if (isConfirmed) {
        // Якщо підтверджено, відбувається редірект до точки видалення з ідентифікатором об'єкту
        window.location.href = 'users/delete?id=' + id;
    }
}