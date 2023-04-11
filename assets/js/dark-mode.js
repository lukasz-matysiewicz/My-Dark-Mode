jQuery(document).ready(function($) {
    // Check if dark mode is enabled
    if (localStorage.getItem('dark-mode') === 'enabled') {
        $('body').attr('my-dark-mode', 'dark');
    } else {
        $('body').attr('my-dark-mode', 'light');
    }

    // Toggle dark mode on button click
    $('[data-dark-mode-toggle]').on('click', function() {
        if ($('body').attr('my-dark-mode') === 'dark') {
            $('body').attr('my-dark-mode', 'light');
            localStorage.removeItem('dark-mode');
        } else {
            $('body').attr('my-dark-mode', 'dark');
            localStorage.setItem('dark-mode', 'enabled');
        }
    });
});