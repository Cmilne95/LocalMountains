<?php
include "top.php";

$yourURL = $domain . $phpSelf;

//variables for form
$firstName = "";
$lastName = "";
$resort = "Jay Peak";
$email = "olandweh@uvm.edu";

$emailERROR = false;
$firstNameERROR = false;
$lastNameERROR = false;

$errorMsg = array();
$mailed = false;

if (isset($_POST["btnSubmit"])) 
{
    $dataRecord = array();
    
    if (!securityCheck(true)) 
    {
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
    $resort = htmlentities($_POST["Mountain"],ENT_QUOTES,"UTF-8");
    $dataRecord[] = $resort;

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

    if(!$errorMsg)
    {
        //save data
        $fileExt = ".csv";
        $myFileName = "data/registration";
        $filename = $myFileName . $fileExt;
        $file = fopen($filename, 'a'); 
        fputcsv($file, $dataRecord);
        fclose($file);
        //create message
        $message = '<h2>Your information.</h2>';
        foreach ($_POST as $key => $value){
            $message .="<p>";
            
            $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
            foreach ($camelCase as $one){
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
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) 
    { 
        print "<h1>Registration is ";
        if(!$mailed)
        {
            print "not ";
        }
        print "successful</h1>";
        print "<p>We have ";
        if (!$mailed) {
           print "not "; 
        }    
        print "sent an email ";
        print "To: " . $email . "</p>";
        
        
        
    }
    else 
    {    
        // display any error messages before we print out the form
        if ($errorMsg) 
        {    
            print '<div id="errors">';
            print "<ol>\n";
            foreach ($errorMsg as $err) 
            {    
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
                        <label for="Mountain">Favorite place to SHRED</label>
                        <select id="Mountain"
                             name="Mountain" 
                             tabindex="520" >
                             <option <?php if($resort=="Jay Peak") print " selected "; ?>
                                 value="Jay Peak">Jay Peak</option>
                             <option <?php if($resort=="Sugarbush") print " selected "; ?>
                                 value="Sugarbush">Sugarbush</option>
                             <option <?php if($resort=="Stowe") print " selected "; ?>
                                 value="Stowe">Stowe</option>
                             <option <?php if($resort=="Bolton") print " selected "; ?>
                                 value="Bolton">Bolton</option>
                        </select>
        </fieldset>
        
        <fieldset class="contact">
                        <legend>Contact Information</legend>
                        
                        <label for="txtFirstName" class="required">First Name
                            <input type="text" id="txtFirstName" name="txtFirstName"
                               value="<?php print $firstName; ?>"    
                               tabindex="100" maxlength="45" placeholder="Enter your first name"    
                               <?php if ($firstNameERROR) {print 'class="mistake"';} ?>    
                               onfocus="this.select()"    
                               autofocus>   
                        
                        </label>
                        
                        <label for="txtLastName" class="required">Last Name
                            <input type="text" id="txtLastName" name="txtLastName"
                               value="<?php print $lastName; ?>"    
                               tabindex="100" maxlength="45" placeholder="Enter your last name"    
                               <?php if ($lastNameERROR) {print 'class="mistake"';} ?>    
                               onfocus="this.select()"    
                               >   
                        
                        </label>
                        
                        <label for="txtEmail" class="required">Email
                            <input type="text" id="txtEmail" name="txtEmail"
                                   value="<?php print $email; ?>"
                                   tabindex="120" maxlength="45" placeholder="Enter a valid email address"
                                   <?php if ($emailERROR){ print 'class="mistake"';} ?>
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