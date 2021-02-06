const options = document.querySelector('.options'); 
const options2 = document.querySelector('.options2'); 
const options3 = document.querySelector('.options3'); 
const arrow1 = document.querySelector('.arrow1');
const arrow2 = document.querySelector('.arrow2');
const arrow3 = document.querySelector('.arrow3');
const choose = document.querySelector('.chooseCategory');
const choose2 = document.querySelector('.chooseHour');
const choose3 = document.querySelector('.chooseCar');

function rollDown(){
    choose.addEventListener('click', () => {
        options.classList.toggle('rollDown');
    })
    choose2.addEventListener('click', () => {
        options2.classList.toggle('rollDown');
    })
    choose3.addEventListener('click', () => {
        options3.classList.toggle('rollDown');
    })
}

function flip(){
    choose.addEventListener('click', () => {
        arrow1.classList.toggle('flip');
    })
    choose2.addEventListener('click', () => {
        arrow2.classList.toggle('flip');
    })
    choose3.addEventListener('click', () => {
        arrow3.classList.toggle('flip');
    })
}

rollDown()
flip()



