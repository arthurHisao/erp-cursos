document.addEventListener('DOMContentLoaded', ()=> {
    'use-strict';

    let formBuy = document.querySelector('#form-buy'),
        btnSend = document.querySelector('.btn-size'),
        message = document.querySelector('#msg');
        

    formBuy.addEventListener('submit', (event) => {
        event.preventDefault();

        if(validateFields(event) === false) {
            return false;
        } else {
            sendData();
            event.preventDefault();
        }
    });

    /*obtendo o plano*/
    /*function plan() {
        let url = window.location.href,
        segment = url.split('/');
        return segment[4];
    }*/

    function validateFields(event) {
        let regex = /^(\w{2})[a-zA-Z À-ú]{1,}$/igm;
        let detectRepeat = /([a-zA-Z0-9])\1\1/igm;
        let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/igm;
        if(formBuy.name.value === "" || formBuy.cpf.value === "" || formBuy.plans.value === "Selecione os planos") {
            alertMessage("Preencha os campos!", 'alert-danger');
            event.preventDefault();
            return false;
        }

        if (!formBuy.name.value.match(regex) || formBuy.name.value.match(detectRepeat)) {       
            alertMessage('Verifique se digitou o nome corretamente', 'alert-danger'); 
            formBuy.name.focus();
            event.preventDefault();
            return false;      
        } else if (formBuy.cpf.value.match(detectRepeat) || formBuy.length > 11) {
            alertMessage('Verifique se digitou CPF corretamente', 'alert-danger'); 
            formBuy.cpf.focus();
            event.preventDefault();
            return false;
        }
    }

    function sendData(){ 
        const baseURL = window.origin,
            _token = document.querySelector('[name="csrf-token"]').getAttribute('content');
        
        let formData = new FormData(),
            inputValues = JSON.stringify({
                "inputName": formBuy.name.value, 
                "inputCPF": formBuy.cpf.value,
                "select": formBuy.plans.value
            });

        formData.append('formValue', inputValues);
        
        //ajax fechar modal
        fetch(baseURL+'/generate', {
            method:'POST', 
            body: formData,
            headers: {
                'X-CSRF-TOKEN': _token,
            },
        }).then(response => response.text()) 
        .then((response) => {
            if(response.length > 45) {
                btnSend.disabled = true;
                window.open(response, '_blank', 'toolbar=0,location=0,menubar=0');
            } else {
                message.style.display = 'block';
                message.innerHTML = response;
            } 
        }).catch(err => {
            message.innerHTML = err;
        });
    }


    function alertMessage(msg, alert) { 
        message.style.display = 'block';       
        message.classList.add(alert);
        message.innerHTML = msg;
        setTimeout(() => {
            message.classList.remove(alert)
            message.innerHTML = "";
        }, 4000);
    }
});