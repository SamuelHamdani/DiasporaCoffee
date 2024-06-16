document.addEventListener('DOMContentLoaded', () => {
    const cart = {
        items: [],
        total: 0,
        quantity: 0,
        addItem(newItem) {
            const cartItem = this.items.find(item => item.name === newItem.name);

            if (!cartItem) {
                this.items.push({ ...newItem, quantity: 1, total: newItem.price });
                this.quantity++;
                this.total += newItem.price;
            } else {
                cartItem.quantity++;
                cartItem.total = cartItem.price * cartItem.quantity;
                this.quantity++;
                this.total += newItem.price;
            }
            this.updateCart();
        },
        removeItem(name) {
            const cartItem = this.items.find(item => item.name === name);

            if (cartItem.quantity > 1) {
                cartItem.quantity--;
                cartItem.total = cartItem.price * cartItem.quantity;
                this.quantity--;
                this.total -= cartItem.price;
            } else {
                this.items = this.items.filter(item => item.name !== name);
                this.quantity--;
                this.total -= cartItem.price;
            }
            this.updateCart();
        },
        updateCart() {
            const cartItemsContainer = document.getElementById('cart-items');
            cartItemsContainer.innerHTML = '';

            if (this.items.length === 0) {
                document.getElementById('cart-empty').style.display = 'block';
                document.getElementById('cart-total').style.display = 'none';
                document.getElementById('checkout-form-container').style.display = 'none';
            } else {
                document.getElementById('cart-empty').style.display = 'none';
                document.getElementById('cart-total').style.display = 'block';
                document.getElementById('checkout-form-container').style.display = 'block';

                this.items.forEach(item => {
                    const itemElement = document.createElement('div');
                    itemElement.classList.add('cart-item');
                    itemElement.innerHTML = `
                        <img src="${item.img}" alt="${item.name}">
                        <div class="item-detail">
                            <h3>${item.name}</h3>
                            <div class="item-price">
                                <span>${rupiah(item.price)}</span> &times;
                                <button class="remove" data-name="${item.name}">&minus;</button>
                                <span>${item.quantity}</span>
                                <button class="add" data-name="${item.name}">&plus;</button> &equals;
                                <span>${rupiah(item.total)}</span>
                            </div>
                        </div>
                    `;
                    cartItemsContainer.appendChild(itemElement);
                });

                document.getElementById('cart-total-value').textContent = rupiah(this.total);
                document.getElementById('hidden-items').value = JSON.stringify(this.items);
                document.getElementById('hidden-total').value = this.total;
            }
        }
    };

    function rupiah(number) {
        return 'Rp. ' + number.toLocaleString('id-ID');
    }

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const productCard = button.closest('.product-card');
            const newItem = {
                name: productCard.getAttribute('data-name'),
                price: parseFloat(productCard.getAttribute('data-price')),
                img: productCard.getAttribute('data-img')
            };
            cart.addItem(newItem);
        });
    });

    document.getElementById('cart-items').addEventListener('click', (e) => {
        if (e.target.classList.contains('remove')) {
            const name = e.target.getAttribute('data-name');
            cart.removeItem(name);
        } else if (e.target.classList.contains('add')) {
            const name = e.target.getAttribute('data-name');
            const item = cart.items.find(item => item.name === name);
            cart.addItem(item);
        }
    });

    // Initial update
    cart.updateCart();
});

// Form Validation
const checkoutButton = document.querySelector('.checkout-button');
checkoutButton.disabled = true;

const form = document.querySelector('#checkoutForm');

form.addEventListener('keyup', function() {
    for(let i = 0; i < form.elements.length; i++) {
        if(form.elements[i].value.length !== 0) {
            checkoutButton.classList.remove('disabled');
            checkoutButton.classList.add('disabled');
        } else {
            return false;
        }
    }
    checkoutButton.disabled = false;
    checkoutButton.classList.remove('disabled');
})

// Kirim data ketika tombol checkout di klik
checkoutButton.addEventListener('click', function(e) {
    e.preventDefault();
    const formData = new FormData(form);
    const data = new URLSearchParams(formData);
    const objData = Object.fromEntries(data);
    const message = formatMessage(objData);
    window.open('http://wa.me/+6285219674120?text=' + encodeURIComponent(message));
});

// Format Pesan Whatsaoo
const formatMessage = (obj) => {
    return `Data Customer
        Nama: ${obj.name}
        Email: ${obj.email}
        No HP: ${obj.phone}
Data Pesanan
    ${JSON.parse(obj.items).map((item) => `${item.name} (${item.quantity} x ${rupiah(item.total)}) \n`)}
    TOTAL: ${rupiah(obj.total)}
    Terima Kasih.`;
}

// Konversi mata uang ke Rupiah
const rupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    }).format(number);
}