const dayButton = document.querySelector('.day');
const weekButton = document.querySelector('.week');
const day = document.querySelector('.dayContainer');
const week = document.querySelector('.weekContainer');
   
var number;

function changeNumber(n){
        
        dayButton.addEventListener('click', () =>{
            n = 1 
        }); 
        weekButton.addEventListener('click', () =>{
            n = 2;
            console.log(n)
        })
    }

    changeNumber(number);

    if(number = 1){
        day.classList.add('appear')
        week.classList.add('dissapear')
    }
    
    else if(number = 2){
        day.classList.remove('appear')
        day.classList.add('dissapear')
        week.classList.remove('dissapear')
        week.classList.add('appear')
    }




