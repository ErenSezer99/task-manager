const themeToggleButton = document.getElementById('themeToggleBtn');
const body = document.body;
const navbar = document.getElementById('navbar');

if (localStorage.getItem('theme') === 'dark') {
    body.setAttribute('data-bs-theme', 'dark');
    navbar.setAttribute('data-bs-theme', 'dark'); 
    navbar.classList.remove('navbar-light', 'bg-white'); 
    navbar.classList.add('navbar-dark', 'bg-dark'); 
    themeToggleButton.textContent = '🌞'; 
} else {
    body.setAttribute('data-bs-theme', 'light');
    navbar.setAttribute('data-bs-theme', 'light'); 
    navbar.classList.remove('navbar-dark', 'bg-dark');
    navbar.classList.add('navbar-light', 'bg-white'); 
    themeToggleButton.textContent = '🌙'; 
}

themeToggleButton.addEventListener('click', () => {
    if (body.getAttribute('data-bs-theme') === 'light') {
        body.setAttribute('data-bs-theme', 'dark');
        navbar.setAttribute('data-bs-theme', 'dark'); 
        navbar.classList.remove('navbar-light', 'bg-white'); 
        navbar.classList.add('navbar-dark', 'bg-dark'); 
        themeToggleButton.textContent = '🌞'; 
        localStorage.setItem('theme', 'dark'); 
    } else {
        body.setAttribute('data-bs-theme', 'light');
        navbar.setAttribute('data-bs-theme', 'light'); 
        navbar.classList.remove('navbar-dark', 'bg-dark');
        navbar.classList.add('navbar-light', 'bg-white'); 
        themeToggleButton.textContent = '🌙'; 
        localStorage.setItem('theme', 'light'); 
    }
});
