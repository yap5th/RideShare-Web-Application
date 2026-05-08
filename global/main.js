// Menu & Overlay
function showMenu(id) {
    const menu = document.querySelector('.' + id);
    const overlay = document.querySelector('.menu-overlay');
    if (!menu) return;

    menu.classList.add('active');
    if (overlay) overlay.classList.add('active');
}

function closeMenu(id) {
    const menu = document.querySelector('.' + id);
    const overlay = document.querySelector('.menu-overlay');
    if (!menu) return;

    menu.classList.remove('active');
    if (overlay) overlay.classList.remove('active');
}




// Login Popup
const loginPage = document.getElementById("loginPage");

function showLoginPopup() {
    loginPage.classList.add("active");
    document.body.classList.add("modal-open");
    closeMenu('mobileNavi'); 
}

function closeLoginPopup() {
    loginPage.classList.remove("active");
    document.body.classList.remove("modal-open");
    c.classList.remove('register-active');
    c.classList.remove('driver-active');
}





// Login / Registration Forms
const c = document.querySelector('.login-container');

function showRegister() {
    c.classList.add('register-active');
}

function showLogin() {
    c.classList.remove('register-active');
}

function openDriverRegister() {
    c.classList.add('driver-active');
}

function closeDriverRegister() {
    c.classList.remove('driver-active');
}





//menu highlight
document.addEventListener("DOMContentLoaded", () => {
    const currentPage = window.location.pathname.split("/").pop();
    const menuLinks = document.querySelectorAll(".leftSideBar nav.menu a");

    menuLinks.forEach(link => {
        const linkPage = link.getAttribute("href").split("/").pop();
        if (linkPage === currentPage) {
            link.classList.add("active");
        }
    });
});
