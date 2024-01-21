document.addEventListener('DOMContentLoaded', function() {
    let buttons = document.querySelectorAll('.show-modal-button');

    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            let entityId = button.dataset.entityId;
            let fullText = button.dataset.text;

            let modalBody = document.querySelector('.modal-body');
            modalBody.innerHTML = '';

            modalBody.textContent = fullText;

            let modal = new bootstrap.Modal(document.getElementById('contact-note-modal'));
            modal.show();
        });
    });
});