$(document).ready(function () {
  let validator = document.getElementById('sf_res').children.length;;
  console.log("THis is the validator, ", validator);

  if (validator <= 3) {
    location.reload(true);
  }
});

document.addEventListener("DOMContentLoaded", function (event) {
  const buttons = document.getElementsByClassName('item-result');
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
  // let cookie = "<?php echo $_COOKIE["username"]; ?>";

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
