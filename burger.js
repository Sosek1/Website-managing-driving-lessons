const burger = document.querySelector('.burger');
const list = document.querySelector('.list');
const body = document.querySelector('body');
burger.addEventListener('click', () => {
	list.classList.toggle('showNav');
	burger.classList.toggle('open');
	body.classList.toggle('overflow');
});



