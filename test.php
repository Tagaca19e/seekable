<div id="tester">
<?php
require_once "db.php";
        $logged_in = false;
        $db = get_connection();

        $query = $db->prepare(
            "SELECT * FROM project3 WHERE email = 'jojo'"
        );

        $query->execute();

        $result = $query->get_result();

        while ($row = $result->fetch_assoc()) {
          
            echo $row["information"];

        }

    
?>
</div>

<script>

        let testx = document.getElementById('tester').innerText;
        testx = "{" + testx.toString() + "}";
        console.log(testx);


        let jsond_decoded = JSON.parse(testx);


        console.log(jsond_decoded);

</script>
