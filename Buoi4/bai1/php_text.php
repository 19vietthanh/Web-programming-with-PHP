<?php
require_once("./mysqlConnect.php");
$country = $_REQUEST['slCountry'];

$stm = $conn->prepare('SELECT customerName, phone, city FROM customers WHERE country =? ');
$stm->bind_param('s', $country);
$stm->execute();
$results = $stm->get_result();
$rs = "<table>";
$rs .= "<th>Name</th><th>Phone</th><th>City</th>";
while ($row = $results->fetch_assoc()) {
    $rs .= "<tr>";
    $rs .= "<td>" . $row["customerName"] . "</td>";
    $rs .= "<td>" . $row["phone"] . "</td>";
    $rs .= "<td>" . $row["city"] . "</td>";
    $rs .= "</tr>\n";
}
$rs .= "</table>";
echo $rs;
