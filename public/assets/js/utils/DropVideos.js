'use-strict';

    var btnUpload = document.querySelector('.btn-upload'), 
        dropForm = document.querySelector('.drop-form'),
        dropArea = document.querySelector('.drop-area'),
        inputFile = document.querySelector('[name=file]'),
        message = document.querySelector('.message'),
        imgContainer = document.getElementById('img-container'),
        successMessage = document.querySelector('.success-msg'),
        progressBar = document.querySelector('#progress'),
        files = [],    
        id = 0,   
        newVal = [],
        extensions = [];

    (() => {
        btnUpload.disabled = true;
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
            for(let i = 0; i < inputFile.files.length; i++) {
                let file = inputFile.files[i];                
                id = i;
                handleFiles(file, id);
            }
        });
    }

    // faz a leitura do arquivo arrastado
    function readValue(evt) {
        let data = evt.dataTransfer;
        let files = data.files;
        handleDropFiles(files);
    }

    function handleFiles(file, id) {
        fileMaxSize(file, file.size, id)
    }

    //permite criar cada novo arquivo de visualizacao
    function handleDropFiles(files) {
        files = [...files];
        
        files.forEach((val) => {
            fileMaxSize(val, val.size, id++);
        });
    }

    // arquivo e tamanho e id
    function fileMaxSize(val,size,Id) {   
        //inserindo nome e tamanho do arquivo
        newVal.push(size);
        //soma dos valores dentro do array
        let sumResult = newVal.reduce(function(sumResult, newVal) {
            return sumResult += newVal;
        }, 0);

        if(sumResult >= 2147483648) {
            alert('valor máximo atingido');
            newVal.pop();
        } else {
            previewFile(val, Id, sumResult);
        }
    }

    // pre visualizacao do arquivo
    function previewFile(file, Id, sumResult) {                  
        regex = new RegExp("(.*?)\.(webm|mov|mp4)$");

        //validando a extensao
        if(!regex.test(file.name)) {
            message.innerHTML = "Formato de arquivo não suportado!";
            newVal.pop();
            return false;
        }

        let reader = new FileReader();
        reader.readAsDataURL(file);

        reader.onloadstart = () => {
            message.innerHTML = file.name;
            createLoadingEl(Id, file.name);                    
        }

        reader.onloadend = ()=> {
            let loading = document.querySelectorAll('.drop-img');
            loading.src = '/assets/images/video.png';

            //havendo duplicidade
            loading.forEach((img) => {
                img.src = '/assets/images/video.png';   
            });
            files.push[file];
            upload(file, sumResult);    
            btnUpload.disabled = false;
        }
    }

    function createLoadingEl(Id, fileName) {
        const imgEl = document.createElement('img');
        imgEl.id = Id;
        imgEl.classList.add("drop-img");
        imgEl.title = fileName;
        imgEl.src = "/assets/images/file-loading.gif";
        imgContainer.appendChild(imgEl);      
    }

    function upload(file, sumResult) {
        dropForm.addEventListener('submit', (event)=> {
            event.preventDefault();
            
            progressBar.style.display = 'block';

            let formData = new FormData();  
            formData.append('file[]', file);
            formData.append('fileSize', JSON.stringify(sumResult));

            const _token = document.querySelector('[name="csrf-token"]').getAttribute('content'),
                xhr = new XMLHttpRequest(),
                baseURL = window.origin;
         
            xhr.open('POST', baseURL+'/send/videos');    
            xhr.upload.addEventListener('progress', e => {
                const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;
                progressBar.style.width = percent.toFixed(0) + '%';
                progressBar.innerHTML = percent.toFixed(0) + '%';

            });

            xhr.onreadystatechange = () => {
                if(xhr.readyState === 4 && xhr.status === 200) {
                    if(xhr.response === 'Arquivo movido com sucesso' || xhr.response) {
                        successMessage.style.display = 'block';
                        successMessage.innerHTML = xhr.response;
                        clear();
                    }
                }
            };
            xhr.setRequestHeader('X-CSRF-TOKEN', _token);
            xhr.send(formData);
        });
    }

    function clear() {
        newVal = [];
        let imgEl = document.querySelectorAll('.drop-img');
        imgEl.forEach((el) => {
            inputFile.value = null;
            message.innerHTML = "Insira ou arraste um arquivo";
            el.remove();
        });
        btnUpload.disabled = true;
    }

    function createProgressBar() {
        let width = document.createElement('div');
        width.id = 'bar';
        progressBar.appendChild(width);     
    }