document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll(
        '.conf-step .conf-step__button-accent, .conf-step .conf-step__seances-movie, .conf-step .conf-step__movie'
    );
    const dismissButtons = document.querySelectorAll('.popup__dismiss, .conf-step__button-regular');
    const popups = document.querySelectorAll('.popup');

    buttons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const target = button.getAttribute('data-target');
            const popup = document.querySelector(target);
            popup.classList.add('active');
        });
    });

    dismissButtons.forEach(function(dismissButton) {
        dismissButton.addEventListener('click', function() {
            popups.forEach(function(popup) {
                popup.classList.remove('active');
            });
        });
    });
});
