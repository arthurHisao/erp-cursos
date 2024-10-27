let ready = document.addEventListener('DOMContentLoaded', ()=> {
    //'use strict';

    var formRegister = document.querySelector('.form-register'),
        message = document.querySelector('#msg');
        

    /*quando clicar no botao*/
    formRegister.addEventListener('submit', (event) => {
        if(validateFields() === false) {
            event.preventDefault();
        }
    });

    function validateFields() {   
        if (!formRegister.name.value.match(/^(\w{2})[a-zA-Z ]{1,}$/g)) { // padrao g = global procura todas as ocorrencias       
            alertMessage('A quantidade mínima é de 3 caracteres, não é valido acentuação por exemplo: João, José', 'alert-danger'); 
            formRegister.name.focus();
            return false;      
        } else if (!formRegister.email.value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
            alertMessage('Endereço de e-mail inválido', 'alert-danger'); 
            formRegister.email.focus();
            return false;
        }
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


        /*function validate() {   
        fields.forEach((input) => {
            if(input.value === "") {
                alertMessage("Preencha os campos em vermelho");
                input.style.cssText = "border-color: #80bdff outline: 0; box-shadow: 0 0 0 0.2rem rgba(240, 52, 52, 0.7 );";
                selectState.style.cssText = "border-color: #80bdff outline: 0; box-shadow: 0 0 0 0.2rem rgba(240, 52, 52, 0.7 );";
                return false;
            } 
        });

        if(inputName.value.match(/(.)\1{2}/)) {
            alertMessagMessagee('Digite um nome válido', 'alert-warning'); 
            inputName.focus();
            return false;  
        } 

        if (!inputName.value.match(/^(\w{2})[a-zA-Z ]{1,}$/g)) { // padrao g = global procura todas as ocorrencias       
            alertMessage('A quantidade mínima é de 3 caracteres, não é valido acentuação por exemplo: João, José', 'alert-warning'); 
            inputName.focus();
            return false;      
        } else if (!inputEmail.value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
            alertMessage('Endereço de e-mail inválido', 'alert-danger'); 
            inputEmail.focus();
            return false;
        }
    }*/