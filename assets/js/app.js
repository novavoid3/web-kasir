document.addEventListener('DOMContentLoaded', function(){

const body =
document.body;

const darkBtn =
document.getElementById('darkModeToggle');

const title =
document.querySelector('.logo-text');

function setDarkMode(enable){

if(enable){

/* DARK MODE */

body.classList.add('dark-mode');

localStorage.setItem('darkMode','true');

/* ICON BULAN */

if(darkBtn){

darkBtn.innerHTML =
'<i class="fa-solid fa-moon"></i>';

}

/* TEXT PUTIH */

if(title){

title.style.color = '#000000';

}

}else{

/* LIGHT MODE */

body.classList.remove('dark-mode');

localStorage.setItem('darkMode','false');

/* ICON MATAHARI */

if(darkBtn){

darkBtn.innerHTML =
'<i class="fa-solid fa-sun"></i>';

}

/* TEXT HITAM */

if(title){

title.style.color = '#000000';

}

}

}

/* LOAD MODE */

if(localStorage.getItem('darkMode') === 'true'){

setDarkMode(true);

}else{

setDarkMode(false);

}

/* TOGGLE MODE */

if(darkBtn){

darkBtn.addEventListener('click', function(){

setDarkMode(
!body.classList.contains('dark-mode')
);

});

}

/* SIDEBAR MOBILE */

const sidebar =
document.querySelector('.sidebar');

const btnSidebar =
document.getElementById('toggleSidebar');

if(btnSidebar){

btnSidebar.addEventListener('click', function(){

sidebar.classList.toggle('active');

});

}

});