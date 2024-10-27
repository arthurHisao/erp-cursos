let ready = document.addEventListener('DOMContentLoaded', ()=> {

'use strinct';

    var btnLogin = document.querySelectorAll('.btn-size');

    (function() {
        localStorage.clear();

        //detecta se possui localstorage
        window.addEventListener('storage', () => {
            alert('uma janela está aberto');        
            setInterval(() => {
                window.location.reload(true);
            }, 900);
        });


        btnLogin.forEach((btn) => {
            btn.addEventListener('click', () => {
                localStorage.setItem('state', 'true');
            });
        });
    })();
});