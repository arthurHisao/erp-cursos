let ready = document.addEventListener('DOMContentLoaded', ()=> {
    'use-strict';

    var formEditVideo = document.querySelector('#form-edit-video'),
        formUploadImage = document.querySelector('#form-upload-image'),
        message = document.querySelector('#msg');
        
    formEditVideo.addEventListener('submit', (event) => {
        event.preventDefault();
        validate() === false ? false : upload();
    });

    formatLink();
    editTab();

    function formatLink() {
        let link = formEditVideo.link;

        link.addEventListener('input', (evt) => {
            evt.target.value = evt.target.value.replace(/\s+/g, '-');
        });
    } 

    function editTab() {
        let alterTab = document.querySelectorAll('.alter-tab');
        
        alterTab.forEach((tab, index) => {
            tab.addEventListener('click', () => {
                if(index === 0) {
                    formEditVideo.style.display = "block";
                    formUploadImage.style.display = "none";
                } else {
                    formEditVideo.style.display = "none";
                    formUploadImage.style.display = "block";
                }
            });
        });  
    }

    function validate() {
        const regexLink = /\s+|^[-/]|$\/\1|([-])\1|-$|[^a-z0-9-]/gi;
        const regex = /([a-zA-Z À-ú0-9\/\-\._\(\):])/gi;
       
        if(!formEditVideo.title.value.match(regex)) {
            alertMessage('Digite um título de vídeo válido', 'alert-danger');
            formEditVideo.title.focus();
            return false;
        } else if (formEditVideo.link.value.match(regexLink) || formEditVideo.link.value === '') {       
            alertMessage('Digite um nome de link válido', 'alert-danger');
            formEditVideo.link.focus();
            return false;      
        } else if (!formEditVideo.description.value.match(regex)) {       
            alertMessage('Digite uma descrição válida', 'alert-danger');
            formEditVideo.description.focus();
            return false;      
        } 

        if(formEditVideo.categories.value === 'Selecione uma categoria') {
            alertMessage('Selecione uma categoria', 'alert-danger');
            return false;
        }
    }

    function upload() {

            let url = window.location.href;
            let explode = url.split('/');

            const _token = document.querySelector('[name="csrf-token"]').getAttribute('content');     
            const xhr = new XMLHttpRequest();
            const values = JSON.stringify({
                "id": explode[6],
                "title": formEditVideo.title.value, 
                "link": formEditVideo.link.value,
                "description": formEditVideo.description.value, 
                "categories": formEditVideo.categories.value
            });


            let formData = new FormData(); 
            formData.append('values', values);

            xhr.open('POST', 'http://localhost:8000/edit/videos');    
        
            xhr.onreadystatechange = () => {
                if(xhr.readyState === 4 && xhr.status === 200) {
                    message.innerHTML = xhr.response;
                    clear();
                } else {
                    message.innerHTML = "Ocorreu um erro tente novamente"
                    clear();
                }
            };
            xhr.setRequestHeader('X-CSRF-TOKEN', _token);
            xhr.send(formData);
    }

    function clear() {
        formEditVideo.reset();
    }

    function alertMessage(msg, alert) {        
        message.classList.add(alert);
        message.innerHTML = msg;
        setTimeout(() => {
            message.classList.remove(alert)
            message.innerHTML = "";
        }, 4000);
    }
});