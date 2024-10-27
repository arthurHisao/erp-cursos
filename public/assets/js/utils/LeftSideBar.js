'use strinct';
(() => {
    let menu = document.querySelector('#menu-toggle');
    let wrapper = document.querySelector('#wrapper');

    let listItems = document.querySelectorAll('.list-group-item');
    let url = window.location.href;

    menu.addEventListener('click',  event => {            
        event.preventDefault();
        wrapper.classList.toggle('toggled');
    });
})();