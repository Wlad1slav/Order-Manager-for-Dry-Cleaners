function editCustomer(id, name, phone, discount, advertising_company) {
    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('phone').value = phone;
    document.getElementById('discount').value = discount;
    document.getElementById('advertising_company').value = advertising_company;
}

function switchStatus(column, newStatus, orderID) {
    $.ajax({
        type: "GET",
        url: "orders/switchStatus",
        data: {column: column, newStatus: newStatus, orderID: orderID},
    });
}