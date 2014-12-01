<?php
include "top.php";
$yourURL = $domain . $phpSelf;
//variables for form
$firstName = "";
$lastName = "";
$resort = "Jay Peak";
$email = "olandweh@uvm.edu";
$backCountry = false;
$racing = false;
$park = true;
$hotTub = false;
$style = "both";
$emailERROR = false;
$firstNameERROR = false;
$lastNameERROR = false;
$errorMsg = array();
$mailed = false;
if (isset($_POST["btnSubmit"])) {
    $dataRecord = array();

    if (!securityCheck(true)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }

    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;
    $lastName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $lastName;
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;
    $resort = htmlentities($_POST["Mountain"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $resort;
    $style = htmlentities($_POST["radStyle"],ENT_QUOTES, "UTF-8");
    $dataRecord[] = $style;
    if (isset($_POST["chkBackCountry"])) {
       $backCountry = true; 
    }else{
        $backCountry = false;
    }
    $dataRecord[] = $backCountry;
    if (isset($_POST["chkRacing"])) {
       $racing = true; 
    }else{
        $racing = false;
    }
    $dataRecord[] = $racing;
    if (isset($_POST["chkPark"])) {
       $park = true; 
    }else{
        $park = false;
    }
    $dataRecord[] = $park;
    if (isset($_POST["chkHotTub"])) {
       $hotTub = true; 
    }else{
        $hotTub = false;
    }
    $dataRecord[] = $hotTub;
    
    if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have extra characters.";
        $firstNameERROR = true;
    }
    if ($lastName == "") {
        $errorMsg[] = "Please enter your last name";
        $lastNameERROR = true;
    } elseif (!verifyAlphaNum($lastName)) {
        $errorMsg[] = "Your last name appears to have extra characters.";
        $lastNameERROR = true;
    }
    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be incorrect.";
        $emailERROR = true;
    }
    if (!$errorMsg) {
        //save data
        $fileExt = ".csv";
        $myFileName = "data/registration";
        $filename = $myFileName . $fileExt;
        $file = fopen($filename, 'a');
        fputcsv($file, $dataRecord);
        fclose($file);
        //create message
        $message = '<h2>Your information.</h2>';
        foreach ($_POST as $key => $value) {
            $message .="<p>";

            $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
            foreach ($camelCase as $one) {
                $message .= $one . " ";
            }
            $message.= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
        }
        //mail to user
        $to = $email;
        $cc = "";
        $bcc = "";
        $from = "Santa <noreply@uvm.edu>";
        $todaysDate = strftime("%x");
        $subject = "Success! " . $todaysDate;
        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    }//end if not error message
}//ends if form was submitted
//display form
?>


<article id="main">

<?php
// If its the first time coming to the form or there are errors we are going
// to display the form.
if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) {
    print "<h1>Registration is ";
    if (!$mailed) {
        print "not ";
    }
    print "successful</h1>";
    print "<p>We have ";
    if (!$mailed) {
        print "not ";
    }
    print "sent an email ";
    print "To: " . $email . "</p>";
} else {
    // display any error messages before we print out the form
    if ($errorMsg) {
        print '<div id="errors">';
        print "<ol>\n";
        foreach ($errorMsg as $err) {
            print "<li>" . $err . "</li>\n";
        }
        print "</ol>\n";
        print '</div>';
    }

    //html form
    ?>

        <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmRegister">

            <fieldset  class="listbox">
                <label for="Mountain">Favorite place to SHRED (optional)</label>
                <select id="Mountain"
                        name="Mountain" 
                        tabindex="520" >
                    <option <?php if ($resort == "Jay Peak") print " selected "; ?>
                        value="Jay Peak">Jay Peak</option>
                    <option <?php if ($resort == "Sugarbush") print " selected "; ?>
                        value="Sugarbush">Sugarbush</option>
                    <option <?php if ($resort == "Stowe") print " selected "; ?>
                        value="Stowe">Stowe</option>
                    <option <?php if ($resort == "Bolton") print " selected "; ?>
                        value="Bolton">Bolton</option>
                </select>
            </fieldset>

            <fieldset class="radio">
                        <legend>What do you ride? (optional)</legend>
                        <label><input type="radio" 
                              id="radStyleSkiing" 
                              name="radStyle" 
                              value="skiing"
                             <?php if($style=="skiing") print 'checked'?>
                             tabindex="330">Skis</label>
                        <label><input type="radio" 
                            id="radStyleSnowboarding" 
                            name="radStyle" 
                            value="snowboarding"
                            <?php if($style=="snowboarding") print 'checked'?>
                            tabindex="340">Snowboard</label>
                        <label><input type="radio" 
                            id="radStyleBoth" 
                            name="radStyle" 
                            value="both"
                            <?php if($style=="both") print 'checked'?>
                            tabindex="340">Both</label>
                    </fieldset>
            
            <fieldset class="checkbox">
                        <legend>Where are you on the mountain? (optional)</legend>
                            <label><input type="checkbox"
                                  id="chkBackCountry"
                                  name="chkBackCountry"
                                  value="backCountry"
                                  <?php if ($backCountry) print 'checked '; ?>
                                   tabindex="420">
                                Back Country</label>
                        <label><input type="checkbox"
                                  id="chkPark"
                                  name="chkPark"
                                  value="park"
                                  <?php if ($park) print 'checked '; ?>
                                   tabindex="420">
                                Park</label>
                        <label><input type="checkbox"
                                  id="chkRacing"
                                  name="chkRacing"
                                  value="racing"
                                  <?php if ($racing) print 'checked '; ?>
                                   tabindex="420">
                                Racing</label>
                        <label><input type="checkbox"
                                  id="chkHotTub"
                                  name="chkHotTub"
                                  value="hotTub"
                                  <?php if ($hotTub) print 'checked '; ?>
                                   tabindex="420">
                                Hot Tub</label>
                    </fieldset>
            
            <fieldset class="contact">
                <legend>Contact Information</legend>

                <label for="txtFirstName" class="required">First Name
                    <input type="text" id="txtFirstName" name="txtFirstName"
                           value="<?php print $firstName; ?>"    
                           tabindex="100" maxlength="45" placeholder="Enter your first name"    
    <?php if ($firstNameERROR) {
        print 'class="mistake"';
    } ?>    
                           onfocus="this.select()"    
                           autofocus>   

                </label>

                <label for="txtLastName" class="required">Last Name
                    <input type="text" id="txtLastName" name="txtLastName"
                           value="<?php print $lastName; ?>"    
                           tabindex="100" maxlength="45" placeholder="Enter your last name"    
    <?php if ($lastNameERROR) {
        print 'class="mistake"';
    } ?>    
                           onfocus="this.select()"    
                           >   

                </label>

                <label for="txtEmail" class="required">Email
                    <input type="text" id="txtEmail" name="txtEmail"
                           value="<?php print $email; ?>"
                           tabindex="120" maxlength="45" placeholder="Enter a valid email address"
                           <?php if ($emailERROR) {
                               print 'class="mistake"';
                           } ?>
                           onfocus="this.select()" 
                           >
                </label>
            </fieldset>

            <fieldset class="buttons">
                <legend></legend>
                <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" tabindex="900" class="button">
            </fieldset>
        </form>
    <?php
}
?>

</article>

</body>
</html>