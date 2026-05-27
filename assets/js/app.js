document.addEventListener('DOMContentLoaded', ()=>{

const body = document.body;
const toggle = document.getElementById('darkModeToggle');
const sidebar = document.querySelector('.sidebar');
const menu = document.getElementById('toggleSidebar');

if(localStorage.getItem('darkMode')==='true'){
body.classList.add('dark-mode');
}

toggle?.addEventListener('click',()=>{
body.classList.toggle('dark-mode');
localStorage.setItem('darkMode',body.classList.contains('dark-mode'));
});

menu?.addEventListener('click',()=>{
sidebar.classList.toggle('active');
});

});