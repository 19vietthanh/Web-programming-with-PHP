<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL</title>
</head>
<body>
    
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <label style="font-weight: bold">Your SQL:</label><br>
    <textarea name="strSQL">
    <?php echo isset($_POST["strSQL"])?$_POST["strSQL"]:""; ?>
    </textarea><br>
    <input type="reset"><input type="submit">
    </form>
    <h4>Result: </h4>

 <?php   
    isset($_POST["strSQL"]) or exit; 
    require("mysqlConnect.php");
    $rs=$mysqli->query($_POST["strSQL"]) or die ($mysqli->error);
    if ($rs instanceof mysqli_result) {
        echo $rs->num_rows." row(s).</br>";
        $table="<table class='tb_result'>";
        $table.="<tr>";
        while ($finfo = $rs->fetch_field())
            $table.="<th>".$finfo->name."</th>";
        $table.="</tr>";
    while($row=$rs->fetch_array()) {
        $table.="<tr>";
        for ($i=0;$i<$rs->field_count;$i++)
            $table.="<td>".$row[$i]."</td>";
        $table.="</tr>";
    }
    $table.="</table>";
        echo $table;
    }else
        echo $mysqli->affected_rows." row(s) affected.";
?>
</body>
</html>