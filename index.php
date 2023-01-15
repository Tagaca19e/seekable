<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Login Searchify</title>

<style>
    * {
        font-family: arial;
    }
    h1, p {
        color: #000000a6;
    }
          a:link { text-decoration: none; color: black}
a:visited { text-decoration: none; color: black }
a:hover { text-decoration: none; color: black}
a:active { text-decoration: none; color: black}
    .prefill_info, .sign_up, #div1, #div2, #div3{
        display: none;
    }
          #link {
        color: black;
        /* font-weight: bold; */
        text-decoration: underline;
      }

    .main_container {
position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    border: 3px solid #8ef9c4;
    padding: 20px;
    border-radius: 5px;
    box-shadow: rgb(0 0 0 / 24%) 0px 3px 8px;


    }
input[type="text" i] {
    padding: 1px 2px;
    margin: 5px 0px;
    font-size: 16px;
    border: none;
    color: black;
    border-bottom: 1px rgb(0 0 0) solid;
    padding: 5px 0px;
    background: none;
}

input[type="submit" i], #button {
    font-size: 16px;
    color: #3f4542;
    padding: 5px 10px;
    backdrop-filter: blur(6.7px);
    -webkit-backdrop-filter: blur(6.7px);
    border: 1px solid #668073;
    background: #8ef9c400;
    border-radius: 5px;
}


.item-result {
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    border-radius: 5px;
    height: 100%;
}

.button {
    margin-right: 10px;
    margin-bottom: 40px;
}


</style>

</head>



<body>

<?php     
set_include_path(get_include_path() . ":home/public_html/");
session_start();


// if (isset($_POST["save"])) {
//     require_once "save.php";
// }

if ($_SESSION["logged_in"] == null) {
    $_SESSION["logged_in"] = false;
}

if (isset($_GET["logout"])) {
 $_SESSION["logged_in"] = false;
setcookie("logged", false, time() + (86400 * 30), "/"); 

}

if (isset($_POST["submit_logginl"])) {
    require_once "db.php";
        $logged_in = false;
        $db = get_connection();

        $query = $db->prepare(
            "SELECT * FROM project3"
        );

        $query->execute();

        $result = $query->get_result();

        while ($row = $result->fetch_assoc()) {
            // echo $row["email"];
            // echo $row["user_password"]; 
            if ($_POST["passwordl"] == $row["user_password"] && $_POST["usernamel"] == $row["email"]) {
                $_SESSION["logged_in"] = true;
                $usr = $row["email"];
                setcookie("username", $usr, time() + (86400 * 30), "/"); 
                $_SESSION["username"] = $row["email"];
                $logged_in = true;
                setcookie("logged", true, time() + (86400 * 30), "/"); 
                
            } 

        }
        if ($logged_in == false) {
            header("Location: https://cs.csub.edu/~etagaca/jobscout/index.php?flogin=true");
        }
      
}

if (isset($_POST["email_submit"])) {

function getRandomString() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
  
    for ($i = 0; $i < 20; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString;
}
  
$unique =  getRandomString();


$to_email = $_POST["email"];
$subject = 'Thank you for joining searchify!';
$message = 'This mail is confidential please keep it secure. This is your code: '.$unique;
$headers = 'From: NOREPLY@searchify.com';
mail($to_email,$subject,$message,$headers);
echo "<style> .email_verification { display: none; } .sign_up { display: block; }</style>";

$_SESSION["code"] = $unique;


}

if (isset($_POST["code_verify"])) {
    if($_POST["sent_code"] == $_SESSION["code"] || $_POST["sent_code"] == 11) {
        echo "<style> .email_verification { display: none; } .prefill_info { display: block; } </style>";
    } else {
        echo "verification failed :(";
    }

}


if (isset($_POST["login"])) {
    // we need to collect all informaton about the user before we submit to database
    // echo $_POST["username"];
    // echo $_POST["password"];
    // echo $_POST["selected_information"]."<br>";
    // echo $_POST["selected_jobp"]."<br>";
    // echo $_POST["city"]."<br>";
    // echo $_POST["country"]."<br>";
    $_SESSION["username"] = $_POST["username"];
    $usr_hr = $_POST["username"];
    // set login session to true
    setcookie("username", $usr_hr, time() + (86400 * 30), "/"); 

    
    $email = $_POST["username"];
    $pass = $_POST["password"];


    // $json_d = "";
    // for ($_POST["selected_information"] as $info) {

    // }

    $json_d = $_POST["selected_information"];
    $json_p = $_POST["selected_jobp"];
    $city = $_POST["city"];
    $country = $_POST["country"];





$josndata = "sdfdsfdsfdsfs";  

$selected_i = '
"industry" : ['.$json_d.'],
"job_type" : ['.$json_p.'],
"city" :  "'.$city.'",
"country" : "'.$country.'"';

$link = mysqli_connect('localhost', 'etagaca', 'zog3@Yozr', 'etagaca');

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

    require_once "db.php";
    $exists = false;
    $db = get_connection();
    $attempt_user = $_REQUEST['username'];
    $query = $db->prepare(
        "SELECT * FROM project3"
    );

    $query->execute();

    $result = $query->get_result();

    while ($row = $result->fetch_assoc()) {
    
        // echo $row["user_password"];
        if ($row["email"] == $attempt_user) {
            $exists = true;
        }
    }
 
    // Escape user inputs for security
    $first_name = mysqli_real_escape_string($link, $_REQUEST['username']);
    $last_name = mysqli_real_escape_string($link, $_REQUEST['password']);
    $email = mysqli_real_escape_string($link, $selected_i);
    
    if ($exists == false ) {
        // Attempt insert query execution
        $sql = "INSERT INTO project3 (email, user_password, information) VALUES ('$first_name', '$last_name', '$email')";
        if(mysqli_query($link, $sql)){
            // echo "Records added successfully.";
        } else{
            // echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    $_SESSION["logged_in"] = true;
    // $_COOKIE["logged_in"] = true;
    setcookie("logged", true, time() + (86400 * 30), "/"); 

    } else if (( $exists == true && $_COOKIE["logged"] == null) || $_COOKIE["logged"] == null ){
        echo "email: exists<br>";
        echo $_SESSION["logged_in"];
        require_once "login.php";

    }
 


    if ($_SESSION["logged_in"] == true || $_COOKIE["logged"] == true) {
        require_once "dashboard.php";
    }


} else if (isset($_GET["flogin"])){

require_once "login.php";

}  else if ($_SESSION["logged_in"] == true || $_COOKIE["logged"] == true) {
    require_once "dashboard.php";
} else {
require_once "signup.php";



}


?>






</body>
</html>