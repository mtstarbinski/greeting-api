<?php

// renders the public facing side of the gutenberg block
    function gapi_greeting_block_render_cb () {
        $res = file_get_contents("URL TO OTHER WORDPRESS SITE");
        if (!$res){
            $message = "We have not received a greeting.";
        } else {
            $greeting = json_decode($res, true);
            $message = $greeting['greeting'];
        }
        ob_start(); ?>
        <h3><?php echo $message ?></h3>
        <?php return ob_get_clean();
    }