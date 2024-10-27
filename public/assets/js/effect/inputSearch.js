document.addEventListener('DOMContentLoaded', ()=> {
    'use strict';

    let inputSearch = document.querySelector('#input-search'),
        label = document.querySelector('.placeholder'),
        btnSearch = document.querySelector('.btn-search');

    
    labelEffect();
    search();

    /*efeito do label subir*/
    function labelEffect() {
        inputSearch.addEventListener('focus', () => {
            label.style.cssText = "top: -15px; font-size: 12px;";
        });

        inputSearch.addEventListener('focusout', () => {
            if(inputSearch.value.length > 0) {
                label.style.cssText = "top: -15px; font-size: 12px;";
            } else {
                label.style.cssText = "position: absolute; top: 10px; pointer-events: none; color: #FFF; transition: 0.8s;";
            }
        });
    }

    function search() {
        btnSearch.addEventListener('click', (evt) => {
            String(inputSearch.value);
        });
    }
});