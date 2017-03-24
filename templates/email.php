<html>
    <body>
        <h3>KRACE GENNEDY EMPLOYEE-WEATHER SCHEDULE UPDATE</h3>

        Dear <b><?= $name ?></b>,
        <br><br>
        Please be informed of the changes regarding your schedule due to weather conditions for the following 5 day period, 
        <b>if you are so scheduled to work on these days</b>:
        <br><br>
        
       <?php
       foreach($adviceList as $date => $list):
       ?>    
          On the date of <?= $date ?> as per weather conditions (<?= ($conditions[$date] === true)? "Rain" : "No Rain"; ?>): <br>
           <?php 
            foreach($list as $key => $advice) {
            ?>

                * <?= $advice ?><br>
        
            <?php
            }
            ?>
            <br><br>  
        <?php
            endforeach;
        ?>
        
        <footer>
            <b>Please be advised that this information is updated on a daily basis, check your email again tomorrow if any further changes have been made.
            These conditions only apply to employees of the <?= $location ?> branch of GraceKennedy. If you happen to receive this email and do not work at said location, note that these conditions do not apply to you.
            </b>
        </footer>
    </body>
</html>
