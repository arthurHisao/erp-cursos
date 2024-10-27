'use strinct';

ready = document.addEventListener('DOMContentLoaded', ()=> {
    
    const del = document.querySelectorAll('.delete'),
        _token = document.querySelector('[name="csrf-token"]').getAttribute('content');

    del.forEach((el) => {
        el.addEventListener('click', (event) => {        
            event.preventDefault();
            const Url = el.href
            
            if(confirm("Deseja mesmo deletar a conta?")) {
                fetch(Url, {
                    method:"POST", 
                    headers: {
                        'X-CSRF-TOKEN': _token,
                    },
                }).then(response => response.text()) 
                .then((response) => {
                    alert(response);
                    window.location.replace("/");
                }).catch(err => {
                    alert(err);
                });
            }
        });
    });
});