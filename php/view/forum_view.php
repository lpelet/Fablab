<?php

function html_chat() {
    $html = <<<END
    <div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-8 offset-md-2">
        <div id="chat-container">
        <div id="messages">
            <!-- Les messages s'afficheront ici -->
        </div>
        <form id="chat-form">
            <input type="text" id="message" placeholder="Entrez votre message..." required>
            <button type="submit">Envoyer</button>
        </form>
    </div>

    <script>
        // Fonction pour charger les messages
        function loadMessages() {
            $.get('/php/modele/load_messages.php', function(data) {
                $('#messages').html(data);
            });
        }

        $(document).ready(function() {
            // Charger les messages toutes les 2 secondes
            setInterval(loadMessages, 2000);

            // Gérer l'envoi de message
            $('#chat-form').submit(function(e) {
                e.preventDefault();
                $.post('php/modele/send_message.php', { message: $('#message').val() }, function() {
                    $('#message').val('');
                    loadMessages();
                });
            });
        });
    </script>
            </div>
    </div>
</div>


END;

    return $html;
}
?>
