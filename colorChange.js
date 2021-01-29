const city = document.querySelector('.city');
const place = document.querySelector('.place');
const vehicle = document.querySelector('.vehicle');
const save = document.querySelector('.save');
city.addEventListener('click', () => {
    city.classList.add("white");
})

place.addEventListener('click', () => {
    place.classList.toggle("white");
})
vehicle.addEventListener('click', () => {
    vehicle.classList.toggle("white");
})
save.addEventListener('click', () => {
    save.classList.toggle("white");
})