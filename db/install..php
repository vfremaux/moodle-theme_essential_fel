<?php

function xmldb_theme_essential_fel_install() {

    // copy all essential configs
    
    $config = get_config('theme_essential');
    foreach($config as $key => $value) {
        set_config($key, $value, 'theme_essential_fel');
    }
}