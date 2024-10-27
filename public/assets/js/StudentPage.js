document.addEventListener('DOMContentLoaded', ()=> {
    'use-strict';

    let formUpdate = document.querySelector('#form-update'),
        inputName = document.querySelector('input[name=name]'),
        inputEmail = document.querySelector('input[name=email]'),
        msg = document.querySelector('.msg'),
        userName  = document.querySelectorAll('.user-name');
    
    const baseURL = window.location.origin;

    /*limpa local storage */
    localStorage.clear();
    
    /*escutando se possui localstorage */
    window.addEventListener('storage', () => {        
        setInterval(() => {
            window.location.replace(baseURL+"/logout");
        }, 500);
    });
    setLocalSotrage();

    /*quando clicar para atualizar usuario*/
    formUpdate.addEventListener('submit', (event) => {
        validateFields(event);
        event.preventDefault();
        update();
    });

    function setLocalSotrage() {
        let logoutLink = document.querySelector('#logout');
        logoutLink.addEventListener('click', (event) => {
            localStorage.setItem('state', 'true');
        });
    }

    function validateFields(event) {
        let regex = /^(\w{2})[a-zA-Z ]{1,}$/igm;
        let detectRepeat = /([a-zA-Z])\1\1/igm;
        let onlyLetters = /[^a-zA-Z]/g; 

        if(inputName.value === "" || inputEmail.value === "") {
            alert("Preencha os campos!");
            event.preventDefault();
            return false;
        }

        if (!inputName.value.match(regex) || inputName.value.match(detectRepeat || inputName.value.match(onlyLetters))) {       
            alert('Verifique se digitou o nome corretamente'); 
            inputName.focus();
            return false;      
        } else if (!inputEmail.value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
            alert('Endereço de e-mail inválido'); 
            inputEmail.focus();
            return false;
        }
    }


    function update() {
        let inputValues = JSON.stringify({"inputName": inputName.value, "inputEmail": inputEmail.value});
        let formData = new FormData();
        formData.append('formValue', inputValues);
       
        const _token = document.querySelector('[name="csrf-token"]').getAttribute('content');

        //ajax fechar modal
        fetch(baseURL+"/update/student", {
            method:"POST", 
            body: formData,
            headers: {
                'X-CSRF-TOKEN': _token,
            },
        }).then(response => response.text()) 
        .then((response) => {
            if(response === "Dados alterado com sucesso") {
                userName.forEach((name) => {
                    name.innerHTML = inputName.value;
                    name.innerHTML = inputName.value.charAt(0).toUpperCase() + inputName.value.slice(1);
                });    
                msg.innerHTML = response;
            } 
        }).catch(err => {
           msg.innerHTML = err;
        });
    }
});