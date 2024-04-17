<!DOCTYPE html>
<html>
<head>
    <title>XEM LỊCH</title>
</head>
<body>
    <h2>Select Month and Year</h2>
    <form method="post" action="">
        <label for="month">Month:</label>
        <select name="month" id="month">
            <?php
            $months = array(
                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
            );
            foreach ($months as $key => $value) {
                echo "<option value=\"$key\">$value</option>";
            }
            ?>
        </select>
        <label for="year">Year:</label>
        <select name="year" id="year">
            <?php
            $current_year = date('Y');
            for ($i = $current_year+10; $i >=$current_year -10 ; $i--) {
                echo "<option value=\"$i\">$i</option>";
            }
            ?>
        </select>
        <button type="submit" name="submit">Go!</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $selected_month = $_POST['month'];
        $selected_year = $_POST['year'];

        $start_date = new DateTime("$selected_year-$selected_month-01");
        $num_days = $start_date->format('t');

        echo "<h2>Calendar for $months[$selected_month] $selected_year</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>";
        echo "<tr>";
        
        $weekday = $start_date->format('w');
        for ($i = 0; $i < $weekday; $i++) {
            echo "<td></td>";
        }
        for ($day = 1; $day <= $num_days; $day++) {
            echo "<td>$day</td>";
            $weekday++;
            if ($weekday == 7) {
                echo "</tr><tr>";
                $weekday = 0;
            }
        }
        while ($weekday < 7) {
            echo "<td></td>";
            $weekday++;
        }
        echo "</tr>";
        echo "</table>";
    }
    ?>
</body>
</html>