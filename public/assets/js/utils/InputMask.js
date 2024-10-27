const masks = {
    cpf(value) {
        return value
        .replace(/\D/g,'')
        //grupo de caracteres
        //(\d) os numeros do campo
        //$1.$2 insere a mascara
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d)/, '$1.$2')
        .replace(/(\d{3})(\d{1,2})/, '$1-$2')
        .replace(/(-\d{2})\d+?$/, '$1')
    },

    birthday(value) {
        return value
        .replace(/\D/g,'')
        .replace(/(\d{2})(\d)/, '$1/$2')
        .replace(/(\d{2})(\d)/, '$1/$2')
        .replace(/(\/\d{4})\d+?$/, '$1')
    },

    phone(value) {
        return value
        .replace(/\D/g,'')
        .replace(/(\d{0})(\d)/, '$1($2')
        .replace(/(\d{2})(\d)/, '$1) $2')
        .replace(/(\d{4})(\d)/, '$1-$2')
        .replace(/(\d{4})-(\d)(\d{4})/, '$1$2-$3')
        .replace(/(-\d{4})\d+?$/, '$1')
    }
}
document.querySelectorAll('.input-mask').forEach(($input) => {
    //evento de quando digitar
    $input.addEventListener('input', (evt) => {
        //obtendo cada campo
        const field = $input.dataset.js;
        evt.target.value = masks[field](evt.target.value); 
    }, false);
});