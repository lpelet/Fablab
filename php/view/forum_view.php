<?php

require_once("generic_view.php");

function html_forum() {
    $html = <<<END
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="chat-container">
                    <div id="chat-box" style="height: 300px; overflow-y: scroll; background: #f9f9f9; padding: 10px;">
                        <!-- Les messages seront chargés ici -->
                    </div>
                    <form id="chat-form">
                        <input type="text" id="chat-message" placeholder="Tapez un message..." required />
                        <button type="submit">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
END;

    return $html;
}

?>
