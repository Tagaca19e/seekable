<div style="display: none;" id="data_holder">
<?php


        $dbhost = 'localhost';
        $dbuser = 'etagaca';
        $dbpass = 'zog3@Yozr';
        $dbname = 'etagaca';
        $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        

        if($mysqli->connect_errno ) {
        // printf("Connect failed: %s<br />", $mysqli->connect_error);
        exit();
        }
        // printf('Connected successfully.<br />');
        

        $usr11 = $_POST["what_user"];
        // echo "username: $usr";  

        $sql = "SELECT * FROM project3 where email = '$usr11'";
        
        $result = $mysqli->query($sql);
        $ress = "";        

        while($row = $result->fetch_assoc()) {
            echo $row["saved"];  
            $ress = $row["saved"];
        }

?>
</div>

<div id="searchify-inner-saved">

</div>

<script>


</script>