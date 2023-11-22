<?php

require_once('../config/conexion.php');

try {
    $tablesQuery = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' AND table_type = 'BASE TABLE'";
    $tablesResult = $db56->query($tablesQuery);

    if ($tablesResult !== false) {
        $tableNames = $tablesResult->fetchAll(PDO::FETCH_COLUMN);

        // Display the table names in an HTML table with buttons
        echo "<div style='text-align: center;'>";
        echo "<form method='post'>";
        echo "<table border='1' style='margin: 0 auto;'>";
        echo "<tr><th>Public Tables</th></tr>";
        foreach ($tableNames as $tableName) {
            echo "<tr><td><button type='submit' name='showTable' value='$tableName'>$tableName</button></td></tr>";
        }
        echo "</table>";
        echo "</form>";
        echo "</div>";

        // Handle the form submission
        if (isset($_POST['showTable'])) {
            $selectedTable = $_POST['showTable'];

            // Display the content of the selected table
            $selectQuery = "SELECT * FROM $selectedTable";
            $selectResult = $db56->query($selectQuery);

            if ($selectResult !== false) {
                $tableContent = $selectResult->fetchAll(PDO::FETCH_ASSOC);

                // Display the content in a simple table
                echo "<div style='text-align: center;'>";
                echo "<h2>Content of $selectedTable</h2>";
                echo "<table border='1' style='margin: 0 auto;'>";
                if (!empty($tableContent)) {
                    echo "<tr>";
                    foreach (array_keys($tableContent[0]) as $column) {
                        echo "<th>$column</th>";
                    }
                    echo "</tr>";
                    foreach ($tableContent as $row) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>$value</td>";
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td>No data in the table</td></tr>";
                }
                echo "</table>";
                echo "</div>";
            } else {
                echo "Error fetching table content.";
            }
        }
    } else {
        echo "Error fetching table names.";
    }
}
catch (Exception $e) {
    $db56->rollBack();
    echo "Error: $e";
}
?>