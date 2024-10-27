document.addEventListener('DOMContentLoaded', ()=> {
    'use strict';

    let listGroup = document.querySelectorAll('.list-group-item '),
        currentLink = window.location.href;
    
    listGroup.forEach((el) => {

        if(currentLink === el.href) {
            el.classList.add('selected');            
        }
        
        el.addEventListener('click', (event) => {
            let link = el.href;
            el.classList.add('selected');            
        });
    });
});