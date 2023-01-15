<html>
<head>
  <title>PHP Test</title>
</head>

<body>
  <div>
    <?php

    // This is going to be the dashboard of the page
    // They will set their preferences when they sign up and use that to 
    // search relevant jobs mathcing their skills
    $url = "https://serpapi.com/search.json?engine=google_jobs&q=SofwareEngineerIntern&google_domain=google.com&gl=us&api_key=dde068a2fdf01689775d465a9389b58745dcf023d2fa39acb223c7bee31e00cd";

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

    echo "<br><br>";

    foreach ($data_f as $d) {
      $pieces = explode(" ", $d["title"]);
      $link = $pieces[0] . " " . $pieces[1] . " " . $d["company_name"];
      $link = str_replace(' ', '+', $link);
      $f_link = "https://www.google.com/search?q=" . $link . "&oq=" . $link . "&aqs=chrome..69i57.479j0j9&sourceid=chrome&ie=UTF8&ibp=htl;jobs&sa=X&ved=2ahUKEwiRvrGficr3AhWBTN8KHV6GCkcQkd0GegQIJhAB#fpstate=tldetail&sxsrf=ALiCzsbcpS3zhDJfTASUf91Qjswm1ZXbw:1651812544050&htivrt=jobs";
      // echo $f_link;
    
      $company_logo = $d["thumbnail"];
      if ($company_logo == "") {
        $company_logo = "job.png";
      }

      // Store it into a js model then hide it on client side
      $json = json_encode($d);

      echo "<div style='border: 1px solid black'>
              <a href='$f_link'>
                <img src=" . $company_logo . " height='50' width='50'>
              </a>
              <input type='hidden' value=" . $json . ">
              <p>" . $d["title"] . "</p>
              <p>" . $d["company_name"] . " . " . $d["location"] . "</p>
              <p>" . $d["detected_extensions"]["schedule_type"] . "</p>
            </div>";
      echo "<br>";

      // After encoding this will be a new object so need to use classes
      $json_decode = json_decode($json);
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
</body>

</html>