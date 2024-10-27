let ready = document.addEventListener('DOMContentLoaded', ()=> {
    'use-strict';

    var btnSave = document.querySelector('[name=btn-save]'),
        userId = document.querySelector('#user-id').innerHTML,
        formUpdate = document.querySelector('#form-update'),
        selectStatus = document.querySelector('[name=status]');
    

    btnSave.addEventListener('click', event => {
        if(selectStatus.value === "Selecione") {
            event.preventDefault();    
            alert('Preencha um valor');
        } else {
            event.preventDefault();

            const _token = document.querySelector('[name="csrf-token"]').getAttribute('content'),
                  baseURL = window.origin;
            
            let value = JSON.stringify({"id": userId, "status": selectStatus.value});
            let formData = new FormData();
            formData.append('value', value);
           
            fetch(baseURL+"/update-payment-status", {
                method:"POST", 
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': _token,
                },
            }).then(response => response.text()) 
            .then((response) => {
                alert(response);
                //window.location.href = baseURL+"/painel-administrativo";
            }).catch(err => {
                alert(err)
            });            
        }
    });
});