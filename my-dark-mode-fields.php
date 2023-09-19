<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

add_settings_section(
    'my_dark_mode_section',
    __('', 'my-dark-mode'),
    'my_dark_mode_section_callback',
    'my_dark_mode'
);

add_settings_field(
    'my_dark_mode_switcher',
    __('<h1>Choose a switcher:</h1>', 'my-dark-mode'),
    'my_dark_mode_switcher_section_callback',
    'my_dark_mode',
    'my_dark_mode_section'
);

add_settings_field(
    'my_dark_mode_colors',
    __('<h1>Define Colors:<h1>', 'my-dark-mode'),
    'my_dark_mode_colors_callback',
    'my_dark_mode',
    'my_dark_mode_section'
);