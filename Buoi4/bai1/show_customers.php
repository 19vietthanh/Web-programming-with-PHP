<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Country</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            margin: 10px;
        }
    </style>
</head>

<body>
    <?php
    require_once("./mysqlConnect.php");
    $sqlTxt = "SELECT DISTINCT country FROM customers ORDER BY country";
    $rs = $conn->query($sqlTxt);
    $opts = "";
    while ($row = $rs->fetch_assoc()) {
        $opts .= "<option>" . $row['country'] . "</option>";
    }
    ?>

    <form id="frmCountry" method="post">
        <Label>Load Customers from </label>
        <select name="slCountry" id="slCountry">
            <?php echo $opts; ?>
        </select>
    </form>
    <br>
    <table id="tbCustomers"></table>
    <script>
        document.getElementById("slCountry").onchange = function() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                const txtHTML = this.responseText;
                document.getElementById("tbCustomers").innerHTML = txtHTML;
            }
            xhttp.open("POST", " ./php_text.php");
            const formData = new FormData(document.getElementById("frmCountry"));
            xhttp.send(formData);
        }
    </script>
</body>

</html>