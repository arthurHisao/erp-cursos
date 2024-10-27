'use strinct';

var btnImg = document.querySelector('#btn-img'),
    btnSave = document.querySelector('#btn-save'),
    userImg = document.querySelectorAll('.user-image'),
    modal = document.querySelector('.modal'),
    btnClose = document.querySelector('.close'),
    form = document.querySelector('#form'),
    file = document.querySelector('[name="input_file"]'),
    messageDiv = document.querySelector('#message');
(() => {
    btnSave.disabled = true;

    btnImg.addEventListener('click', (event) => {
        file.click();
    });

    form.addEventListener('submit', event => {
        event.preventDefault();
    });

    /*exibe area do croppie*/
    let view = document.getElementById('image-preview'),
        croppie = new Croppie(view, {
            viewport: { width: 150, height: 150 },
            boundary: { width: 300, height: 250 },
            showZoomer: true,
            enableOrientation: true
        });

    /*exibe a imagem padrao*/    
    croppie.bind({
        url: '/assets/images/none.png',
    });

    closeAction(croppie);
    loadImage(croppie);
})();

function loadImage(croppie) {
    /*exibindo a imagem selecionada*/
    btnImg.addEventListener('change', event => {
        let fileReader = new FileReader();
        let inputFile = event.target.files[0];

        //faz a leitura do arquivo
        fileReader.readAsDataURL(inputFile);
        
        fileReader.onload = (evt) => {

            regex = new RegExp("(.*?)\.(jpeg|jpg|png)$");

            //validando a extensao
            if(!regex.test(inputFile.type)) {
                messageDiv.innerHTML = "Formato de arquivo não suportado!";
                return false;
            }        

            croppie.bind({
                url: evt.target.result
            });
            btnSave.disabled = false;

            form.addEventListener('submit', event => {
                event.preventDefault();

                /*aplicando a imagem*/
                userImg.forEach((imgEl) => {
                    imgEl.src = evt.target.result;
                });

                //pagina do administrador elemento imagem
                if(circleImage = document.getElementById("user-image-circle")) {
                    circleImage.src = evt.target.result;
                }

                let formData = new FormData();
                formData.append('file', inputFile);
                sendImage(formData);
            });
        }
    });
}
 
function sendImage(formData) {
    let img = document.createElement('img');
    img.src = '/assets/images/loading.gif';
    messageDiv.appendChild(img);
    img.classList.add('w-25','h-25');

    const _token = document.querySelector('[name="csrf-token"]').getAttribute('content');
    const baseURL = window.origin;

    //ajax fechar modal
    fetch(baseURL+"/send/photo", {
        method:"POST", 
        body: formData,
        headers: {
            'X-CSRF-TOKEN': _token,
        },
    }).then(response => response.text()) 
    .then((response) => {
        messageDiv.innerHTML = response;
        /*if (!response.ok) {
            throw Error(`O correu um erro interno`);
        }*/
    }).catch(err => {
        let msg = err;
        let success = false;
        showMessage(msg, success);
    });
}

function showMessage(msg, success) {
    if(success === true) {
        messageDiv.classList.add('alert-success');
        messageDiv.innerHTML = message;
        setInterval(function() { 
            messageDiv.innerHTML = '';
            messageDiv.classList.remove('alert-success');
            btnSave.disabled = true;
            file.value = null;
            closeModal();
        }, 3000);
    } else {
        messageDiv.classList.add('alert-danger');
        messageDiv.innerHTML = msg;
        setInterval(function() { 
            messageDiv.innerHTML = '';
            messageDiv.classList.remove('alert-danger');
            btnSave.disabled = true;
            file.value = null;
        }, 3000);
    }
}

function closeModal() {
    let jQueryObj = Object.keys(modal).filter((key) => (key.toString().indexOf('jQuery') !== -1) && modal[key].hasOwnProperty('bs.modal'));
    modal[jQueryObj]['bs.modal'].hide();  
}

function closeAction(croppie) {
    modal.addEventListener('keyup', event => {
        btnSave.disabled = true;
        file.value = null;
        if(event.key === 'Escape') {
            btnSave.disabled = true;
            croppie.bind({
                url: '/assets/images/none.png',
            });
            let jQueryObj = Object.keys(modal).filter((key) => (key.toString().indexOf('jQuery') !== -1) && modal[key].hasOwnProperty('bs.modal'));
            modal[jQueryObj]['bs.modal'].hide();        
        }
    });

    btnClose.addEventListener('click', () => {
        btnSave.disabled = true;
        file.value = null;
        //resetando a imagem ao fechar
        croppie.bind({
            url: '/assets/images/none.png',
        });    
        let jQueryObj = Object.keys(modal).filter((key) => (key.toString().indexOf('jQuery') !== -1) && modal[key].hasOwnProperty('bs.modal'));
        modal[jQueryObj]['bs.modal'].hide();
    });  
}