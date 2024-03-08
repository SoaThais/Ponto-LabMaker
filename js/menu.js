document.addEventListener('DOMContentLoaded', function() {
    let menu = document.querySelector('#menu-icon');
    let sidenavbar = document.querySelector('.side-navbar');
    let content = document.querySelector('.content');
    let below = document.querySelector('.below');

    menu.onclick = () => {
        sidenavbar.classList.toggle('active');
        content.classList.toggle('active');
        below.classList.toggle('active');
    }
});
