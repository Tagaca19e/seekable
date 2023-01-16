<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Login Searchify</title>

    <link rel="stylesheet" href="./assets/seekable.css">
</head>

<body>
    <?php
        // set_include_path(get_include_path() . ":home/public_html/");
        session_start();
        
        if ($_SESSION["logged_in"] == null) {
            $_SESSION["logged_in"] = false;
        }
        
        if (isset($_GET["logout"])) {
            $_SESSION["logged_in"] = false;
            setcookie("logged", false, time() + (86400 * 30), "/");
        }
        
        if (isset($_POST["submit_logginl"])) {
            require_once './apis/db-connect.php';
            $logged_in = false;
            $db = get_connection();
            
            $query = $db->prepare(
                "SELECT * FROM project3"
            );
            
            $query->execute();
            
            $result = $query->get_result();
            
            while ($row = $result->fetch_assoc()) {
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

            $unique = getRandomString();
            $to_email = $_POST["email"];
            $subject = 'Thank you for joining searchify!';
            $message = 'This mail is confidential please keep it secure. This is your code: ' . $unique;
            $headers = 'From: NOREPLY@searchify.com';
            mail($to_email, $subject, $message, $headers);
            echo "<style> .email_verification { display: none; } .sign_up { display: block; }</style>";
            $_SESSION["code"] = $unique;
        }

        if (isset($_POST["code_verify"])) {
            if ($_POST["sent_code"] == $_SESSION["code"] || $_POST["sent_code"] == 11) {
                echo "<style> .email_verification { display: none; } .prefill_info { display: block; } </style>";
            } else {
                echo "verification failed :(";
            }
        }

        if (isset($_POST["login"])) {
            $_SESSION["username"] = $_POST["username"];
            $usr_hr = $_POST["username"];
            setcookie("username", $usr_hr, time() + (86400 * 30), "/");
            $email = $_POST["username"];
            $pass = $_POST["password"];
            $json_d = $_POST["selected_information"];
            $json_p = $_POST["selected_jobp"];
            $city = $_POST["city"];
            $country = $_POST["country"];

            $selected_i = '
                "industry" : [' . $json_d . '],
                "job_type" : [' . $json_p . '],
                "city" :  "' . $city . '",
                "country" : "' . $country . '"';

            $link = mysqli_connect('localhost', 'etagaca', 'zog3@Yozr', 'etagaca');

            // Check connection
            if ($link === false) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            require_once "./apis/db.php";
            $exists = false;
            $db = get_connection();
            $attempt_user = $_REQUEST['username'];
            $query = $db->prepare(
                "SELECT * FROM project3"
            );

            $query->execute();

            $result = $query->get_result();

            while ($row = $result->fetch_assoc()) {
                if ($row["email"] == $attempt_user) {
                    $exists = true;
                }
            }

            // Escape user inputs for security
            $first_name = mysqli_real_escape_string($link, $_REQUEST['username']);
            $last_name = mysqli_real_escape_string($link, $_REQUEST['password']);
            $email = mysqli_real_escape_string($link, $selected_i);

            if ($exists == false) {
                // Attempt insert query execution
                $sql = "INSERT INTO project3 (email, user_password, information) VALUES ('$first_name', '$last_name', '$email')";
                if (mysqli_query($link, $sql)) {
                }
                $_SESSION["logged_in"] = true;
                setcookie("logged", true, time() + (86400 * 30), "/");
            } else if (($exists == true && $_COOKIE["logged"] == null) || $_COOKIE["logged"] == null) {
                echo "email: exists<br>";
                echo $_SESSION["logged_in"];
                require_once "./pages/login.php";
            }

            if ($_SESSION["logged_in"] == true || $_COOKIE["logged"] == true) {
                require_once "./pages/dashboard.php";
            }
        } elseif (isset($_GET["flogin"])) {
            require_once "login.php";
        } elseif ($_SESSION["logged_in"] == true || $_COOKIE["logged"] == true) {
            require_once "./pages/dashboard.php";
        } else {
            require_once "./pages/signup.php";
        }
    ?>
</body>
</html>
