//VARIABLE STACK

let menuBut = document.querySelector('.menuButton'),
    closeBut = document.querySelector('.closeButton'),
    nav = document.querySelector('.navArea'),
    body = document.querySelector('body'),
    cont = document.querySelector('.page'),
    info = document.querySelector('.navInfo');



function openMenu() {
    if (window.matchMedia("(min-width: 775px)").matches) {
        nav.style.width = "40%";
    } else {
        nav.style.width = "100%";
    }
    nav.classList.remove('op');
    body.classList.add('lock');
};

function closeMenu() {
    nav.style.width = "0";
    body.classList.remove('lock');
    nav.classList.add('op');
};



//EVENT LISTENER

menuBut.addEventListener('click', openMenu);
closeBut.addEventListener('click', closeMenu);
cont.addEventListener('click', closeMenu);