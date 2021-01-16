const dayButton = document.querySelector('.day');
const weekButton = document.querySelector('.week');
const day = document.querySelector('.dayContainer');
const week = document.querySelector('.weekContainer');
   


dayButton.addEventListener('click', () => {
    day.classList.add('appear')
    week.classList.remove('appear')
})
    
weekButton.addEventListener('click', () => {
    day.classList.remove('appear')
    week.classList.add('appear')
})

  

 




       


   




