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


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">FABLAB</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->
        
        
    </div>            
END;

    return $html;
}