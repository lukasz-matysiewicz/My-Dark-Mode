document.addEventListener('DOMContentLoaded', function() {
    var logoImage = document.querySelector('.custom-logo');
    var originalLogoSrc = logoImage ? logoImage.src : '';
    var html = document.documentElement;

    function updateLogoSrc() {
        if (logoImage) {
            var darkMode = html.getAttribute('my-dark-mode') === 'dark';

            if (darkMode && '<?php echo esc_url($dark_logo_url); ?>' !== '') {
                logoImage.src = '<?php echo esc_url($dark_logo_url); ?>';
            } else if (!darkMode && '<?php echo esc_url($light_logo_url); ?>' !== '') {
                logoImage.src = '<?php echo esc_url($light_logo_url); ?>';
            } else {
                logoImage.src = originalLogoSrc;
            }
        }
    }

    updateLogoSrc();

    if (window.MutationObserver) {
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'my-dark-mode') {
                    updateLogoSrc();
                }
            });
        });

        observer.observe(html, { attributes: true });
    }
});