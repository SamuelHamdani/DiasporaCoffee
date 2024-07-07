const navbarNav = document.querySelector('.navbar-nav');
// Ketika menu di klik
document.querySelector('#nav-menu').onclick = () => {
    navbarNav.classList.toggle('active')
}

// Toggle class active untuk shopping cart
const shoppingCart = document.querySelector('.shopping-cart');
document.querySelector('#shopping-cart-button').onclick = (e) => {
    shoppingCart.classList.toggle('active');
    e.preventDefault();
}

// klik diluar element
const menu = document.querySelector('#nav-menu');
const sc = document.querySelector('#shopping-cart-button');

document.addEventListener('click', function (e) {
    if (!menu.contains(e.target) && !navbarNav.contains(e.target)) {
        navbarNav.classList.remove('active');
    }
    if (!sc.contains(e.target) && !shoppingCart.contains(e.target)) {
        shoppingCart.classList.remove('active');
    }
});