<div class="main_container">
    <div class="email_verification">
        <form method="POST" action="<?= $_SERVER["PHP_SELF"] ?>">
            <input id="text" type="text" name="email" placeholder="Enter email" required>
            <input type="submit" name="email_submit" value="Send"><br>
            <p> Already have an account?
                <a href="https://cs.csub.edu/~etagaca/jobscout/index.php?flogin=true"> Log in</a>
            </p>
        </form>
    </div>

    <div class="sign_up">
        <form method="POST" action="<?= $_SERVER["PHP_SELF"] ?>">
            <input id="text" type="text" name="sent_code" placeholder="Enter sent code" required>
            <input type="submit" name="code_verify" value="Submit">
        </form>
    </div>

    <div class="prefill_info">
        <form method="POST" id="login_form" action="<?= $_SERVER["PHP_SELF"] ?>">
            <div id="div0">
                <input id="text" type="text" name="username" placeholder="Enter name" required> <br>
                <input id="text" type="text" name="password" placeholder="Enter password"> <br> <br>
                <a id="button" onclick="next()"> Next >> </a>
            </div>

            <div id="div1">
                <input class="info" type="checkbox" name="selection" value="Software Engineering"> Software Engineering
                <br>
                <input class="info" type="checkbox" name="selection" value="Back end Developer"> Back end Developer <br>
                <input class="info" type="checkbox" name="selection" value="Front end Developer"> Front end Developer
                <br>
                <input class="info" type="checkbox" name="selection" value="Full-Stack Engineer"> Full-Stack Engineer
                <br>
                <input class="info" type="checkbox" name="selection" value="Data Analyst"> Data Analyst <br>
                <input id="selected_info" type="hidden" name="selected_information"> <br>
                <a id="button" onclick="next()"> Next </a>
            </div>

            <div id="div2">
                <input class="job_p" type="checkbox" name="selection" value="internship"> Internship <br>
                <input class="job_p" type="checkbox" name="selection" value="full time"> Full time <br>
                <input class="job_p" type="checkbox" name="selection" value="part time"> Part time <br>
                <input id="selected_jobp" type="hidden" name="selected_jobp"> <br>
                <a id="button" onclick="next()"> Next </a>
            </div>

            <div id="div3">
                <input id="city" type="text" name="city" placeholder="Enter City">
                <input id="country" type="text" name="country" placeholder="Enter Country">
                <a id="button" onclick="submit()"> Submit </a>
                <input style="display: none" id="login" type="submit" name="login" value="Login">
            </div>
        </form>
    </div>
</div>

<script>
    let global_step = 0;
    function next() {
        let temp_str0 = "div" + global_step.toString();
        document.getElementById(temp_str0).style = "display: none;";
        global_step += 1;
        let temp_str = "div" + global_step.toString();
        document.getElementById(temp_str).style = "display: block;";
    }

    function submit() {
        let selection = document.getElementsByClassName('info');
        let temp_array = [];
        for (let selec of selection) {
            if (selec.checked) {
                console.log(selec);
                let svi = selec.value;
                svi = "\"" + svi.toString() + "\"";
                temp_array.push(svi);
            }
        }

        let selected_jobp = document.getElementsByClassName('job_p');
        let temp_jobp = []
        for (let sp of selected_jobp) {
            if (sp.checked) {
                let spi = sp.value;
                spi = "\"" + spi.toString() + "\"";
                temp_jobp.push(spi);
            }
        }
        document.getElementById('selected_info').value = temp_array;
        document.getElementById('selected_jobp').value = temp_jobp;
        document.getElementById('login').click();
    }

    let selected_jobp = document.getElementsByClassName('job_p');
    let email_done = 0;
    $(document).ready(function () {
        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                if (event.target.name == "selection" ||
                    event.target.name == "username" ||
                    event.target.name == "password" ||
                    event.target.name == "country" ||
                    event.target.name == "city") {
                    event.preventDefault();
                    if (global_step == 3) {
                        submit();
                    } else {
                        next();
                    }
                    return false;
                }
                return true;
            }
        });
    });
</script>
