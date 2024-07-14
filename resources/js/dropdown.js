document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.getElementById('menu-button');
    const dropdownMenu = menuButton.nextElementSibling;

    menuButton.addEventListener('click', function () {
        const isExpanded = menuButton.getAttribute('aria-expanded') === 'true';
        menuButton.setAttribute('aria-expanded', !isExpanded);
        dropdownMenu.classList.toggle('hidden', isExpanded);
    });

    // Optional: Click outside to close the menu
    document.addEventListener('click', function (event) {
        if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            menuButton.setAttribute('aria-expanded', 'false');
            dropdownMenu.classList.add('hidden');
        }
    });
});
