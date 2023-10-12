$(document).ready(function() {
    // Глобальні налаштування для усіх таблиць

    $.extend(true, $.fn.dataTable.defaults, {
        "pageLength": 100, // Максимальна кількість рядків у таблиці
        "lengthChange": false,
        autoWidth: false,
        "order": [[ 0, "desc" ]],
        language: {
            processing: "Завантаження...",
            search: "Пошук:",
            lengthMenu: "Показати _MENU_ записів",
            info: "Записи з _START_ до _END_, загалом _TOTAL_ записів",
            infoEmpty: "Записи з 0 до 0, загалом 0 записей",
            infoFiltered: "(відфільтровано з _MAX_ записів)",
            infoPostFix: "",
            loadingRecords: "Завантаження записів...",
            zeroRecords: "Записи відсутні.",
            emptyTable: "У таблиці відсутні дані",
            paginate: {
                first: "Перша",
                previous: "Попередня",
                next: "Наступна",
                last: "Остання"
            },
            aria: {
                sortAscending: ": активувати для сортування стовпця за зростанням",
                sortDescending: ": активувати для сортування стовпця за спаданням"
            }
        }
    });

});