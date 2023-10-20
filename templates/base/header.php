<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle . ' :: ' . $config['Назва ПЗ']; ?></title>
    <script src="../static/javascript/utils.js"></script>
    <script src="../static/javascript/convertTableToCSV.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <!-- Налаштування DataTables -->
    <script src="../../static/javascript/dataTablesConfig.js"></script>

</head>

<body>

<div class="header">

    <img src="/static/images/logo.png" alt="logo">
    <h1><?php echo $config['Назва ПЗ']?></h1>
    <p class="important-2"><?php echo $config['Версія']?></p>
    <h1 class="UA">.UA</h1>

</div>

<div class="page-container">