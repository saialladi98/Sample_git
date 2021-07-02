<?php
//attribute for database connection
$server = "localhost";
$user = "root";
$password = "Manoj@123";
$database = "phpdb";

// Create connection
$connect = new mysqli($server, $user, $password, $database);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

do {
    //menu list
    echo "\n-----------------------------------\n";
    echo "1.create table";
    echo "\n2.insert values";
    echo "\n3.display table";
    echo "\n4.update table";
    echo "\n5.exit";
    echo "\n-----------------------------------\n";

    $choice = readline("enter your choice");
    //checking whether given number is numeric or not
    if (is_numeric($choice)) {
        switch ($choice) {
            case 1:
                $sql_stmt = "create table studentSample
                             (std_id int,std_name varchar(20),
                              std_branch varchar(20),primary key(std_id))";
                if ($connect->query($sql_stmt) === true) {
                    echo "Table  created successfully";
                } else {
                    echo "Error creating table: " . $connect->error;
                }

                break;
            case 2:
                $sql_stmt = "insert into studentSample VALUES (1, 'abc', 'cse');";
                $sql_stmt .= "insert into studentSample VALUES (2, 'def', 'it');";
                $sql_stmt .= "insert into studentSample VALUES (3, 'xyz', 'mech');";

                if ($connect->multi_query($sql_stmt) === true) {
                    echo "values inserted successfully";
                } else {
                    echo "Error: " . $sql_stmt . "<br>" . $connect->error;
                }
                break;
            case 3:
                $sql_stmt = "select std_id,std_name,std_branch from studentSample";
                $result = $connect->query($sql_stmt);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "id: " . $row["std_id"] . " - Name: " . $row["std_name"] . " branch " . $row["std_branch"] . "\n";
                    }
                } else {
                    echo "0 results";
                }
                break;
            case 4:
                $columnName = readline("which column you would like to update: ");
                $id = readline("enter id value: ");
                $newValue = readline("Enter new value: ");
                //call the update function
                updateValues($columnName, $id, $newValue);
                break;
            case 5:break;
            default:echo "\nplease enter the correct value:";
                    break;
        }
    } else {
        echo "\nEnter numeric value";
    }

} while ($choice != 5);
//function for updating the contents in a table
function updateValues($column, $id, $value)
{
    if($column=="branch" || $column=="std_branch")
    {
        $sql_stmt = "update studentSample set std_branch='$value' where std_id=$id;";
    }

    if ($GLOBALS['connect']->query($sql_stmt) === true) {
        echo "Value updated successfully";
    } else {
        echo "Error has occured while updating value: " . $GLOBALS['connect']->error;
    }

}
