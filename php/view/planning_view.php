<?php
require_once("generic_view.php");

function html_planning($data = [])
{

    $html = <<<END
    <!-- Content Start -->
        <div class="content">
              


            <!-- Button Start -->
            <div id='external-events'>
              
              <div id='calendar-container'>
                <div id='calendar'></div>
              </div>
            <!-- Button End -->


        </div>
        <!-- Content End -->
        
        
    </div>            
END;

    return $html;
}