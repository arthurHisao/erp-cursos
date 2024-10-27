'use-strict';

(() => {

    let listGroup = document.querySelectorAll('.nav-link '),
        currentLink = window.location.href;
    
    listGroup.forEach((el) => {
        if(currentLink === el.href) {
            el.classList.add('active');            
        }
        
        el.addEventListener('click', (event) => {
            let link = el.href;
            el.classList.add('active');            
        });
    });

})();