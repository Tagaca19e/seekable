<html>
<head>
  <title>PHP Test</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
  <div class="searchify-main">
    <div class="searchify-account">

      <div id="bottom_user">
        <p onclick="onl()"> Profile </p>
        <div id="tester" style="display: none">
          <?php
          if ($_COOKIE["username"] !== $_SESSION["username"]) {
            echo "<script> location.reload(true); </script>";
          }

          require_once "db.php";
          $logged_in = false;
          $db = get_connection();
          $current_logged = $_COOKIE["username"];
          $query = $db->prepare(
            "SELECT * FROM project3 WHERE email = '$current_logged'"
          );

          $query->execute();
          $result = $query->get_result();
          while ($row = $result->fetch_assoc()) {
            echo $row["information"];
          }
          ?>
        </div>

        <div id="user_logged_info" style="display: none">
          <?php
          require_once "db.php";
          $logged_in = false;
          $db = get_connection();
          $current_logged = $_COOKIE["username"];
          $query = $db->prepare(
            "SELECT * FROM project3 WHERE email = '$current_logged'"
          );

          $query->execute();
          $result = $query->get_result();
          while ($row = $result->fetch_assoc()) {
            echo $row["user_password"];
          }
          ?>
      </div>

        <script>
          let to_link = document.getElementById('tester').innerText;
          to_link = "{" + to_link.toString() + "}";
          let to_link_decoded = JSON.parse(to_link);

          let random_ind = Math.floor(Math.random() * to_link_decoded["industry"].length);
          let chosen_ind = to_link_decoded["industry"][random_ind].toLowerCase();
          let random_job_type = Math.floor(Math.random() * to_link_decoded["job_type"].length);
          let chosen_job_type = to_link_decoded["job_type"][random_job_type].toLowerCase();
          let chosen_city = to_link_decoded["city"].toLowerCase();

          let url = "https://serpapi.com/search.json?engine=google_jobs&q=" + chosen_ind + chosen_job_type + "&uule=" + chosen_city + "&google_domain=google.com&api_key=094db260d401e0521854c068f7a4cf1047e8f5b3c1dc0a65849564a194c3dbc3";
          url = url.replace(/\s/g, '');
          document.cookie = "search_url=" + url + "";
        </script>

        <a href="https://cs.csub.edu/~etagaca/3680/project3/index.php?logout=true&flogin=true">Logout</a>
        <div id="overlay_login" onclick="offl()">
          <div style="background: white;
                      position: absolute;
                      left: 50%; top: 50%;
                      transform: translate(-50%, -50%);
                      border: 2px solid #7cb89a;
                      padding: 10px;
                      border-radius: 5px;
                      text-align: left;">
            <p id="current_user">
              <b>Username: </b> <?php $user = $_COOKIE['username']; echo $user; ?>
            </p>
            <p id="current_password"></p>
            <p id="current_industry"></p>
            <p id="current_job_type"></p>
            <p id="current_location"></p>
          </div>
        </div>
      </div>
    </div>

    <div class="searchify-results">
      <div id="overlay" onclick="off()">
        <div id="overlay-content" style="aspect-ratio: 16/9; background: white; margin: auto;">
          <h1 id="job-title"> </h1>
          <p id="company"> </p>
          <p id="posted-on"> </p>
          <p id="what_type"> </p>
          <p id="description"> </p>
          <a id="link" href="" target="_blank">
            <p> View Job -> </p>
          </a>
        </div>
      </div>

      <div class="searchify-inner-shell">
        <div style="display: flex; align-items: center;">
          <div>
            <h1 id="hello"> Hello, <?php $user = $_COOKIE['username'];
            echo $user; ?> </h1>
            <p> Check out your top matches and saved jobs down below! </p>
          </div>
          <form style="margin-left: auto;" method="POST" action="<?= $_SERVER["PHP_SELF"] ?>">
            <input id="text" type="text" name="search" placeholder="Search Jobs" required>
            <input id="queryy" style="display: none;" type="submit" name="queried" value="search">
            <img onclick="query()" src="search.svg" width="20" height="atuo">
          </form>
        </div>

        <script>
          function query() {
            let q = document.getElementById('queryy');
            console.log(q);
            q.click();
          }
        </script>

        <h1 style="color: #76d1a4;"> Top Matches </h1>

        <div id="sf_res" class="searchify-inner-results">
          <?php
            $dochtml = new DOMDocument();
            $dochtml->loadHTMLFile("dashboard.php");

            $div = $dochtml->getElementById('tester')->nodeValue;
            $tester = $_COOKIE["search_url"] . "hello";
            if ($tester == "hello") {
              header("Refresh:0");
              echo "<script> location.reload(); </script>";
            }

            $url = $_COOKIE["search_url"];
            if (isset($_POST["queried"])) {
              $temp_search = $_POST["search"];
              $temp_search = str_replace(' ', '', $temp_search);
              $url = "https://serpapi.com/search.json?engine=google_jobs&q=$temp_search&google_domain=google.com&gl=us&api_key=b5fc0183dea570c664dbbb19d60fa233ea0470eb99fc4769b322e9ffc3ea653b";
            }
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

          $resp = curl_exec($curl);
          curl_close($curl);

          $data = json_decode($resp);
          $data = $data->jobs_results;
          $data_f = object_to_array($data);
          $max = 0;

          foreach ($data_f as $d) {
            $pieces = explode(" ", $d["title"]);
            $link = $pieces[0] . " " . $pieces[1] . " " . $d["company_name"];
            $link = str_replace(' ', '+', $link);
            $f_link = "https://www.google.com/search?q=" . $link . "&oq=" . $link . "&aqs=chrome..69i57.479j0j9&sourceid=chrome&ie=UTF8&ibp=htl;jobs&sa=X&ved=2ahUKEwiRvrGficr3AhWBTN8KHV6GCkcQkd0GegQIJhAB#fpstate=tldetail&sxsrf=ALiCzsbcpS3zhDJfTASUf91Qjswm1ZXbw:1651812544050&htivrt=jobs";
            if ($max > 7) {
              break;
            }
            $company_logo = $d["thumbnail"];

            if ($company_logo == "") {
              $company_logo = "job.png";
            }

            // store it into a js model then hide it on client side
            $json = json_encode($d);

            // we wil replace double quotes with single quotes on the description
            $text = $d["description"];
            $temp_title = $d["title"];
            $temp_location = $d["location"];
            $temp_company = $d["company_name"];
            $temp_thumbnail = $d["thumbnail"];
            $temp_posted_at = $d["detected_extensions"]["posted_at"];
            $temp_schedule = $d["detected_extensions"]["schedule_type"];
            $temp_description = $d["description"];

            $brace = "}";
            $obj_temp = '{
            "title" : "' . $temp_title . '",
            "company_name" : "' . $temp_company . '",
            "location" : "' . $temp_location . '",
            "thumbnail" : "' . $temp_thumbnail . '",
            "description" : "' . $text . '",
            "posted_at" : "' . $temp_posted_at . '",
            "schedule_type" : "' . $temp_schedule . '"}';

            $obj_temp_b = str_replace('"', "'", $obj_temp);

            echo "<div  class='button item-result'>
                    <div style='text-align: end; opacity: 0.5;' onclick='clickMe(event)'> save
                      <div style='display: none;'>
                        {\"title\" : \"$temp_title\", \"company\" : \"$temp_company\", \"type\" : \"$temp_schedule\", \"linkj\" : \"$f_link\" , \"thumbnail\" : \"$temp_thumbnail\" }  
                      </div>
                    </div>
          
                  <a id='right' onclick='on()'>
                    <div id='data' style='display: none;'>
                      $temp_title
                    </div>
                    <div id='data' style='display: none;'>
                      $temp_company
                    </div>
                    <div id='data' style='display: none;'>
                      $temp_location
                    </div>
                    <div id='data' style='display: none;'>
                      $temp_thumbnail
                    </div>
                    <div id='data' style='display: none;'>
                      $temp_description
                    </div>
                    <div id='data' style='display: none;'>
                      $temp_schedule
                    </div>
                    <div id='data' style='display: none;'>
                      $temp_posted_at
                    </div>
                    <div id='data' style='display: none;'>
                      $f_link
                    </div>
                    <div id='data' style='display: none;'>
                      {\"title\" : \"$temp_title\", \"company\" : \"$temp_company\", \"type\" : \"$temp_schedule\", \"linkj\" : \"$f_link\"}  
                    </div>

                    <div  style=' pointer-events: none;'>
                      <img style='border-radius: 5px;' src=" . $company_logo . " height='auto' width='50'>
                      <p>" . $d["title"] . "</p>
                      <p>" . $d["detected_extensions"]["schedule_type"] . "</p>
                      <p>" . $d["company_name"] . " . " . $d["location"] . "</p>
                    </div>
                  </a>
                </div>";
            $max++;
          }

          function saveData() {
            echo "This is the save data";
          }

          function object_to_array($data) {
            if (is_array($data) || is_object($data)) {
              $result = [];
              foreach ($data as $key => $value) {
                $result[$key] = (is_array($data) || is_object($data)) ? object_to_array($value) : $value;
              }
              return $result;
            }
            return $data;
          }
          ?>
        </div>
        <h1 style="color: #76d1a4;"> Saved Jobs </h1>
        <div id='saved_results'></div>
      </div>
      <div style="" id="dummy_div">
      </div>
    </div>
</body>

<script>
  $(document).ready(function () {
    let validator = document.getElementById('sf_res').children.length;;
    console.log("THis is the validator, ", validator);

    if (validator <= 3) {
      location.reload(true);
    }
  });

  document.addEventListener("DOMContentLoaded", function (event) {
    const buttons = document.getElementsByClassName('item-result');

    console.log("This is button: ", buttons);

    for (let button of buttons) {

      button.addEventListener('click', event => {
        let target = event.target;
        if (target.id == "right") {
          let json = target.children[0].innerHTML;
          document.getElementById("job-title").innerHTML = target.children[0].innerHTML;
          document.getElementById("description").innerHTML = "<b>Info: </b> <br>" + target.children[4].innerHTML;
          document.getElementById("company").innerHTML = "<b>Company: </b> " + target.children[1].innerHTML;
          document.getElementById("what_type").innerHTML = "<b>Type: </b> " + target.children[5].innerHTML;
          document.getElementById("link").href = target.children[7].innerText;
        }
      });
    }
  });

  function on() {
    document.getElementById("overlay").style.display = "block";
  }

  function onl() {
    let testx = document.getElementById('tester').innerText;
    testx = "{" + testx.toString() + "}";

    let jsond_decoded = JSON.parse(testx);

    let temp_location = jsond_decoded["city"] + ", " + jsond_decoded["country"];
    let user_pass = document.getElementById('user_logged_info').innerText
    document.getElementById("current_password").innerHTML = "<b>Password:</b> " + user_pass;
    document.getElementById("current_industry").innerHTML = "<b>Industry:</b> <br>" + jsond_decoded["industry"];
    document.getElementById("current_job_type").innerHTML = "<b>Job type:</b> <br>" + jsond_decoded["job_type"];
    document.getElementById("current_location").innerHTML = "<b>Location:</b> " + temp_location;
    document.getElementById("overlay_login").style = "display: block";
  }

  function offl() {
    document.getElementById("overlay_login").style.display = "none";
  }

  function off() {
    document.getElementById("overlay").style.display = "none";
  }


  function logout() {
    <?php
      $_SESSION["logged_in"] = false;
      header("Location: https://cs.csub.edu/~etagaca/3680/project3/index.php?flogin=true");
    ?>
  }

  function clickMe(event) {
    let testt = event.target.children[0].innerText;
    testt = testt;
    let cookie = "<?php echo $_COOKIE["username"]; ?>";
    $.ajax({
      url: 'save.php',
      type: 'post',
      data: { save: testt, user_post: cookie },
      success: function (response) {
        console.log(response);
      }

    }).then(function () {
      show();
    });
  }

  function remove(event) {
    let element = document.getElementById('data_holder');
    let text = element.innerText;
    let parsed_saved1 = text.split("|");

    parsed_saved1.splice(event.target.id, 1);
    let cookie = "<?php echo $_COOKIE["username"]; ?>";
    let new_string = parsed_saved1.join("|");

    $.ajax({
      url: 'update.php',
      type: 'post',
      data: { update: new_string, user_post: cookie },
      success: function (response) {
        console.log(response);
      }
    }).then(function () {
      show();
    });
  }

  function show() {
    let cookie = "<?php echo $_COOKIE["username"]; ?>";

    $.ajax({
      url: 'display.php',
      type: 'post',
      data: { what_user: cookie },
      success: function (response) {
        document.getElementById('saved_results').innerHTML = response;
      }
    }).then(function () {
      let element = document.getElementById('data_holder');
      let text = element.innerText;
      let element2 = document.getElementById('searchify-inner-saved');
      let hide = document.getElementById('sf_res');
      let parsed_saved = text.split("|");

      for (let i = 0; parsed_saved.length; i++) {
        console.log(parsed_saved[i]);
        let sav = parsed_saved[i];
        if (i !== 0) {
          try {
            sav = JSON.parse(sav);
          } catch (e) {
            break;
          }

          let sav_title = sav["title"];
          let sav_company = sav["company"];
          let sav_type = sav["type"];
          let sav_link = sav["linkj"];
          let sav_thumbnail = sav["thumbnail"];

          if (sav_thumbnail == "") {
            sav_thumbnail = "job.png";
          }

          let temp_div = "<div class='item-result'><div style='text-align: end; opacity: 0.5;'><a id='" + i + "' onclick='remove(event)'> remove </a></div><img style='border-radius: 5px;' src='" + sav_thumbnail + "' height='auto' width='50' ><p>" + sav_title + "</p> <p>" + sav_company + "</p> <p>" + sav_type + "</p> <a href='" + sav_link + "' target='_blank'> View >> </a></div>";
          element2.innerHTML += temp_div;
        }
      }
    });
  }
  show();

</script>
</html>