<input 
    name="end_date" 
    class="form-control"  
    type="datetime-local" 
    placeholder="End date"
    min="<?php 
        echo date('Y-m-d\TH:i', strtotime($_GET['start_date'] . ' +1 minute')); 
    ?>"
    value="<?php 
        if(isset($_GET['editid'])) {	
            echo date("Y-m-d\TH:i", strtotime($rsedit['end_date_time'])); 
        } else { 		 
            echo date('Y-m-d\TH:i', strtotime($_GET['start_date'] . ' +1 minute'));
        }	
    ?>"
    <?php 
        if(isset($_GET['editid'])) {
            echo " readonly style='background-color:#fcf8e3;'";
        }
    ?>
>