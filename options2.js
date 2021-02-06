const options = document.querySelector('.options'); 
const options2 = document.querySelector('.options2'); 
const options3 = document.querySelector('.options3'); 
const options4 = document.querySelector('.options4'); 
const arrow1 = document.querySelector('.arrow1');
const arrow2 = document.querySelector('.arrow2');
const arrow3 = document.querySelector('.arrow3');
const arrow4 = document.querySelector('.arrow4');
const choose1 = document.querySelector('.fuel');
const choose2 = document.querySelector('.rideRealized');
const choose3 = document.querySelector('.kind');
const choose4 = document.querySelector('.traningForm');

function rollDown(){
    options.classList.toggle('rollDown');
}

function rollDown2(){
    options2.classList.toggle('rollDown');
}

function rollDown3(){
    options3.classList.toggle('rollDown');
}

function rollDown4(){
    options4.classList.toggle('rollDown');
}


choose1.addEventListener('click', () => {
    arrow1.classList.toggle('flip');
})

choose2.addEventListener('click', () => {
    arrow2.classList.toggle('flip');
})

choose3.addEventListener('click', () => {
    arrow3.classList.toggle('flip');
})
choose4.addEventListener('click', () => {
    arrow4.classList.toggle('flip');
})

