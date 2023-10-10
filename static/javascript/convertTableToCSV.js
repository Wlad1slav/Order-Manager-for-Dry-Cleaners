function convertAndDownloadTable(tableId) {
    let table = document.getElementById(tableId);
    let csv = tableToCSV(table);
    downloadCSV(csv, tableId + '.csv');
}

function tableToCSV(table) {
    var data = [];
    for (let row of table.querySelectorAll('tr')) {
        let rowData = [];
        for (let cell of row.querySelectorAll('td, th')) {
            // Обробляємо коми та нові рядки
            let text = cell.innerText.replace(/"/g, '""');
            if (text.includes(',') || text.includes('\n')) {
                text = `"${text}"`;
            }
            rowData.push(text);
        }
        data.push(rowData.join(','));
    }
    return data.join('\n');
}

function downloadCSV(csv, filename) {
    var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    var link = document.createElement("a");
    link.style.display = 'none';
    link.href = URL.createObjectURL(blob);
    link.download = filename;

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
