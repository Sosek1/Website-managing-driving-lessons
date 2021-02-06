const settle = document.querySelector('.settleRide');

function changeColor(){
    settle.addEventListener('click', () => {
        settle.classList.toggle("white");
    })
}
changeColor()