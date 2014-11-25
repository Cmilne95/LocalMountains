<?php
include "top.php";

$yourURL = $domain . $phpSelf;

//variables for form
$firstName = "";
$lastName = "";
$resort = "Jay Peak";

$emailERROR = false;
$firstNameERROR = false;
$lastNameERROR = false;

$errorMsg = array();

if (isset($_POST["btnSubmit"])) 
{
    $dataRecord = array();
    
    
    
    
}


?>
<article>

    <?php
    // If its the first time coming to the form or there are errors we are going
    // to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) 
    { 
    
        print "<h1>Your Request has ";
        if($emailERROR)
        {
            print "not ";
        }
            
        
        print "been processed</h1>";
 
        
        
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
        
    
    ?>

    <form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmRegister">
        <fieldset class="radio">
                <legend>Survey!</legend>
                <p>What is your favorite place to ride?</p>
                        <label><input type="radio" 
                              id="radResortJay" 
                              name="radResort" 
                              value="jayPeak"
                             <?php if($resort=="jayPeak") print 'checked'?>
                             tabindex="330">Jay Peak</label>
                        <label><input type="radio" 
                            id="radResortBush" 
                            name="radResort" 
                            value="Sugarbush"
                            <?php if($gender=="Sugarbush") print 'checked'?>
                            tabindex="340">Sugarbush</label>
                        <label><input type="radio" 
                            id="radResortStowe" 
                            name="radResort" 
                            value="Stowe"
                            <?php if($gender=="Stowe") print 'checked'?>
                            tabindex="340">Stowe</label>
                        <label><input type="radio" 
                            id="radResortBolton" 
                            name="radResort" 
                            value="Bolton"
                            <?php if($gender=="Bolton") print 'checked'?>
                            tabindex="340">Bolton Valley</label>        
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