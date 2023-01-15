<?php
    $dbhost = 'localhost';
    $dbuser = 'etagaca';
    $dbpass = 'zog3@Yozr';
    $dbname = 'etagaca';
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    

    if($mysqli->connect_errno ) {
    printf("Connect failed: %s<br />", $mysqli->connect_error);
    exit();
    }
    printf('Connected successfully.<br />');
    
    $update = $_POST["update"];
    $usr = $_POST["user_post"];
    echo "username: $usr";  

    $sql = "SELECT * FROM project3 where email = '$usr'";
    
    // $result = $mysqli->query($sql);
    
    $to_update = "";

    // while($row = $result->fetch_assoc()) {
    //     // printf("Id: %s, Title: %s, Author: %s, Date: %d <br />", 
    //     // echo $row["saved"]."This is from database <br>";
    //      $to_update = $row["saved"];  
    // }



    echo $update."This is updated <br>";

    // echo $saved;

    $yy = '{"title":"FrontEndDeveloperFullTime/DirectHire","company":"HaloGroup","type":"Full-time","linkj":"https://www.google.com/search?q=Front+End+Halo+Group&oq=Front+End+Halo+Group&aqs=chrome..69i57.479j0j9&sourceid=chrome&ie=UTF8&ibp=htl;jobs&sa=X&ved=2ahUKEwiRvrGficr3AhWBTN8KHV6GCkcQkd0GegQIJhAB#fpstate=tldetail&sxsrf=ALiCzsbcpS3zhDJfTASUf91Qjswm1ZXbw:1651812544050&htivrt=jobs"}';
    // echo "This is saved $yy";
     
    $gg ="ywllow";   
    if ($mysqli->query("UPDATE project3 set saved = '$update' where email = '$usr'")) {
    printf("Table tutorials_tbl updated successfully.<br />");
    }
    if ($mysqli->errno) {
    printf("Could not update table: %s<br />", $mysqli->error);
    }


    // UPDATE project3 set saved = ''{"title":"Front-EndDeveloperInternship","company":"BitGo","type":"Internship","linkj":"https://www.google.com/search?q=Front-End+Developer+BitGo&oq=Front-End+Developer+BitGo&aqs=chrome..69i57.479j0j9&sourceid=chrome&ie=UTF8&ibp=htl;jobs&sa=X&ved=2ahUKEwiRvrGficr3AhWBTN8KHV6GCkcQkd0GegQIJhAB#fpstate=tldetail&sxsrf=ALiCzsbcpS3zhDJfTASUf91Qjswm1ZXbw:1651812544050&htivrt=jobs"}''  where email = "etagaca@csub.edu"


    mysqli_free_result($result);
    $mysqli->close();
?>