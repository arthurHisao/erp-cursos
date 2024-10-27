'use-strict';

    var btnImage = document.querySelector('#btn-image'), 
        dropForm = document.querySelector('#form-upload-image'),
        dropArea = document.querySelector('.drop-area'),
        inputFile = document.querySelector('[name=file]'),
        message = document.querySelector('.message'),
        successMessage = document.querySelector('.success-message');
        imgContainer = document.getElementById('img-container'),
        progressBar = document.querySelector('#progress');

    (() => {
        btnImage.disabled = true;
        dropForm.addEventListener('submit', (evt) => {
            evt.preventDefault();  
        });

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach((events, index) => {
            dropArea.addEventListener(events, (evt)=> {
                //prevenindo o comportamento padrao
                evt.preventDefault();
                
                switch(index) {
                    case 0:
                        dropArea.style.cssText = "border-color: #ffd669; border: 4px dashed #ffd669;";
                    break;

                    case 1:
                        dropArea.style.cssText = "border-color: #ffd669; border: 4px dashed #ffd669;";
                    break;

                    case 2:
                        dropArea.style.cssText = "border-color: #ffd669; border: 2px dashed #ffd669;";
                    break;

                    case 3:
                        dropArea.style.cssText = "border-color: #ffd669; border: 2px dashed #ffd669;";
                        readValue(evt);
                    break;
                }
            });
        });

        //abre a janela de arquivos
        dropArea.addEventListener('click', evt => {
            inputFile.click();
        });
  
        //faz a leitura dos arquivos selecionados
        readInputValue();
    })();

    function readInputValue() {
        inputFile.addEventListener('change', evt => {
            //percorrendo os arquivos
            let file = evt.target.files[0];
            handleFile(file);
        });
    }

    //faz a leitura do arquivo arrastado
    function readValue(evt) {
        let data = evt.dataTransfer.files;
        handleDropFile(data);
    }

    function handleFile(file) {
        let getFileID = document.getElementById('1');
        
        if(!getFileID) {
            fileMaxSize(file);
        } else {
            alert('É permitido subir apenas 1 arquivo de imagem');
            return false;
        }
    }

    //permite criar cada novo arquivo de visualizacao
    function handleDropFile(data) {
        let fileList = [...data];
        let getFileID = document.getElementById('1');
    
        if(!getFileID) {
            fileList.forEach((file) => {
                fileMaxSize(file);
            });
        } else {
            alert('É permitido subir apenas 1 arquivo de imagem');
            return false;
        }
    }

    // verificando o tamanho do arquivo
    function fileMaxSize(file) {   
        if(file.size > 4194304) {
            alert('valor máximo para imagens é de 4mb');
        } else {
            previewFile(file);
        }
    }

    // pre visualizacao do arquivo
    function previewFile(file) {          
        regex = new RegExp("(.*?)\.(jpg|jpeg|png|gif)$");

        //validando a extensao
        if(!regex.test(file.name)) {
            message.innerHTML = "Formato de arquivo não suportado!";
            return false;
        }

        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onloadstart = () => {
            message.innerHTML = file.name;
            let id = '1';
            createLoadingEl(id, file.name);                    
        }

        reader.onloadend = ()=> {
            let loading = document.querySelector('.drop-img');
            loading.src = '/assets/images/photo-icon.png';
            upload(file, file.size);    
            btnImage.disabled = false;
        }
    }

    function createLoadingEl(id, fileName) {
        let imgEl = document.createElement('img');
        imgEl.id = id;
        imgEl.classList.add("drop-img");
        imgEl.title = fileName;
        imgEl.src = "/assets/images/file-loading.gif";
        imgContainer.appendChild(imgEl);      
    }

    function upload(file) {
        dropForm.addEventListener('submit', (event)=> {
            event.preventDefault();
            progressBar.style.display = 'block';

            let url = window.location.href;
            let explode = url.split('/');
            let formData = new FormData();  
            
            formData.append('file', file);
            /*id da url atual*/
            formData.append('id', JSON.stringify(explode[6]));

            const _token = document.querySelector('[name="csrf-token"]').getAttribute('content'),
                xhr = new XMLHttpRequest(),
                baseURL = window.origin;


            xhr.open('POST', baseURL+'/send/thumbnail');    
            xhr.upload.addEventListener('progress', e => {
                const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;
                progressBar.style.width = percent.toFixed(0) + '%';
                progressBar.innerHTML = percent.toFixed(0) + '%';

            });

            xhr.onreadystatechange = () => {
                if(xhr.readyState === 4 && xhr.status === 200) {
                    successMessage.style.display = 'block';
                    successMessage.innerHTML = xhr.response;
                    clear();
                } else {
                    successMessage.style.display = 'block';
                    successMessage.innerHTML = xhr.response;
                    //clear();
                }
            };
            xhr.setRequestHeader('X-CSRF-TOKEN', _token);
            xhr.send(formData);
        });
    }

    function clear() {
        let imgEl = document.querySelector('.drop-img');
        inputFile.value = null;
        message.innerHTML = "Insira ou arraste um arquivo";
        imgEl.remove();
        btnImage.disabled = true;
    }

    function createProgressBar() {
        let width = document.createElement('div');
        width.id = 'bar';
        progressBar.appendChild(width);     
    }