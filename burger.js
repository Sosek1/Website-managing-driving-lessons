const burger = document.querySelector('.burger');
const list = document.querySelector('.list');
let showMenu = false;
burger.addEventListener('click', () => {
	if (!showMenu) {
		list.classList.add('showNav');
		burger.classList.add('open')
		showMenu = true;
	}
	else {
		list.classList.remove('showNav');
		burger.classList.remove('open');
		showMenu = false;
	}
});



