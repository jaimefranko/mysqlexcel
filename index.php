<!DOCTYPE html>
<html>
<head>
    <title>Subir Archivo Excel</title>
</head>
<body>
    <form action="procesar_excel.php" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo" accept=".xls, .xlsx">
        <input type="submit" value="Cargar Archivo">
    </form>
</body>
</html>
