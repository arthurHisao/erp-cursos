let ready = document.addEventListener('DOMContentLoaded', ()=> {
    'use-strict';

    var btnSave = document.querySelector('[name=btn-save]'),
        userId = document.querySelector('#user-id').innerHTML,
        formUpdate = document.querySelector('#form-update'),
        selectPermission = document.querySelector('[name=permission]');
    

    btnSave.addEventListener('click', event => {
        if(selectPermission.value === "Selecione") {
            event.preventDefault();    
            alert('Preencha um valor');
        } else {
            event.preventDefault();

            let = _token = document.querySelector('[name="csrf-token"]').getAttribute('content');
            let value = JSON.stringify({"id": userId, "permission": selectPermission.value});
            let formData = new FormData();
            formData.append('value', value);
            
            fetch("http://localhost:8000/update-permissions", {
                method:"POST", 
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': _token,
                },
            }).then(response => response.text()) 
            .then((response) => {
                alert(response);
                window.location.href = "http://localhost:8000/painel-administrativo"
            }).catch(err => {
                alert(err)
            });            
        }
    });
});