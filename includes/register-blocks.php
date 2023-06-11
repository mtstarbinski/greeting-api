<?php

function gapi_register_blocks() {
    $blocks = [
        [ 'name' => 'greeting-block', 'options' => [
            'render_callback' => 'gapi_greeting_block_render_cb'
        ]]
    ];

    foreach($blocks as $block) {
        register_block_type(
            GAPI_PLUGIN_DIR . '/build/blocks/' . $block['name'],
            isset($block['options']) ? $block['options'] : []
        );
    }

    
}