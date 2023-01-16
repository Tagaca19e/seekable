<?php
    $dbhost = 'localhost';
    $dbuser = 'etagaca';
    $dbpass = 'zog3@Yozr';
    $dbname = 'etagaca';
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    if ($mysqli->connect_errno ) {
        printf("Connect failed: %s<br />", $mysqli->connect_error);
        exit();
    }
    printf('Connected successfully.<br />');

    $saved = $_POST["save"];
    $usr = $_POST["user_post"];
    echo "username: $usr";

    $sql = "SELECT * FROM project3 where email = '$usr'";
    $result = $mysqli->query($sql);
    $to_update = "";

    while ($row = $result->fetch_assoc()) {
        $to_update = $row["saved"];
    }

    $to_update =  $to_update."|".$saved;
    echo $to_update."This is updated <br>";

    if ($mysqli->query("UPDATE project3 set saved = '$to_update' where email = '$usr'")) {
        printf("Table tutorials_tbl updated successfully.<br />");
    }
    if ($mysqli->errno) {
        printf("Could not update table: %s<br />", $mysqli->error);
    }

    mysqli_free_result($result);
    $mysqli->close();
