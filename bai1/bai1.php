<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <div id="wrap">
        <?php
        require_once ("./mySQLConnect.php");
        $sqlTxt = "SELECT DISTINCT country From customers ORDER BY country";
        $rs = $mysqli->query($sqlTxt);
        $opts = "";
        while ($row = $rs->fetch_assoc()) {
            $opts .= "<option>" . $row['country'] . "</option>";
        }
        ?>
        <form method="POST" id="frmCountry">
            <Label>Load Customers from</Label>
            
            <select name="slCountry" id="slCountry">
                <?php echo $opts; ?>
            </select>
        </form>
        
        <table id="tbCustomers">
            <script>
                document.getElementById("slCountry").onchange = function () {
                    const xhttp = new XMLHttpRequest();
                    xhttp.onload = function () {
                        const txtHTML = this.responseText;
                        document.getElementById("tbCustomers").innerHTML = txtHTML;
                    }
                    xhttp.open("POST", "./php_text.php");
                    const formData = new FormData(document.getElementById("frmCountry"));
                    xhttp.send(formData);
                }
            </script>
        </table>
    </div>
</body>

</html>