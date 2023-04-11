<?php
class My_Dark_Mode_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'my_dark_mode_widget',
            __('Dark Mode Toggle Button', 'my-dark-mode'),
            array('description' => __('A widget to display the dark mode toggle button', 'my-dark-mode'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        echo do_shortcode('[my_dark_mode_toggle_button]');
        echo $args['after_widget'];
    }
}

function my_dark_mode_register_widget() {
    register_widget('My_Dark_Mode_Widget');
}
add_action('widgets_init', 'my_dark_mode_register_widget');