let navbar = document.querySelector('.header .flex .navbar');

if (navbar) {
   document.querySelector('#menu-btn').onclick = () => {
      navbar.classList.toggle('active');
      searchForm.classList.remove('active');
      profile.classList.remove('active');
   }
}

let profile = document.querySelector('.header .flex .profile');

let userBtn = document.getElementById('#user-btn');
if (userBtn) {
   document.querySelector('#user-btn').onclick = () => {
      profile.classList.toggle('active');
      searchForm.classList.remove('active');
      navbar.classList.remove('active');
   }
}

let searchForm = document.querySelector('.header .flex .search-form');

document.querySelector('#search-btn').onclick = () => {
   searchForm.classList.toggle('active');
   navbar.classList.remove('active');
   profile.classList.remove('active');
}
if (profile && navbar && searchForm) {
   window.onscroll = () => {
      profile.classList.remove('active');
      navbar.classList.remove('active');
      searchForm.classList.remove('active');
   }
}

document.querySelectorAll('.content-150').forEach(content => {
   if (content.innerHTML.length > 150) content.innerHTML = content.innerHTML.slice(0, 150);
});