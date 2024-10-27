    let formOne = document.querySelector('#form-one'),
        formTwo = document.querySelector('#form-two'),
        formThree = document.querySelector('#form-three');

    let buttons = [
        document.querySelector('#btn1'),
        document.querySelector('#btn2'),
        document.querySelector('#btn3')
    ];

    function displayForm(){
        buttons.forEach((btn, index) => {
            btn.addEventListener('click', ()=> {
                switch(index) {
                    case 0:
                        formOne.style.display = "block";
                        formTwo.style.display = "none";
                        formThree.style.display = "none";
                    break;

                    case 1:
                        formOne.style.display = "none";
                        formTwo.style.display = "block";
                        formThree.style.display = "none";
                    break;

                    case 2:
                        formOne.style.display = "none";
                        formTwo.style.display = "none";
                        formThree.style.display = "block";
                    break;
                }
            });
        });
    }
    /*executa*/
    displayForm();