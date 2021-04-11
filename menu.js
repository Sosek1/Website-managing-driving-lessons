const burger = document.querySelector('.burger');
const list = document.querySelector('.list');
const body = document.querySelector('body');
const bars = document.querySelector('.fa-bars');
const times = document.querySelector('.fa-times');
let showMenu = false;
times.style.display="none";
burger.addEventListener('click', () => {
	
	if (!showMenu) {
		list.classList.add('showNav');
		bars.style.display="none";
		times.style.display="block";
		showMenu = true;
	}
	else {
		list.classList.remove('showNav');
		bars.style.display="block";
		times.style.display="none";
		showMenu = false;
	}
	body.classList.toggle('overflow');
	
});

