// Menyimpan data produk menggunakan alpine.js
document.addEventListener('alpine:init', () => {
    Alpine.data('products', () => ({
        items: [
            { id: 1, name: 'Latte', img: 'Latte.jpg', price: 20000},
            { id: 2, name: 'Black Coffee', img: 'Black Coffee.jpg', price: 25000},
            { id: 3, name: 'Espresso', img: 'Espresso.jpg', price: 30000},
            { id: 4, name: 'Iced Coffee', img: 'Iced Coffee.jpg', price: 20000},
            { id: 5, name: 'Mocha', img: 'Mocha.jpg', price: 25000},
            { id: 6, name: 'Americano', img: 'Americano.jpg', price: 25000}
        ],
    }));

    // Menambahkan fungsi tombol keranjang
    Alpine.store('cart', {
        items: [],
        total: 0,
        quantity: 0,
        add(newItem) {
            // Cek apakah ada barang yang sama di cart
            const cartItem = this.items.find((item) => item.id === newItem.id);

            // Jika belum ada / cart masih kosong
            if(!cartItem) {
                this.items.push({...newItem, quantity:1, total: newItem.price});
                this.quantity++;
                this.total += newItem.price;
            }else {
                // Jika barang sudah ada, cek apakah barang beda atau sama dengan yang ada di cart
                this.items = this.items.map((item) => {
                    // Jika barang berbeda
                    if(item.id !== newItem.id) {
                        return item;
                    } else {
                        // Jika barang sudah ada, tambah quantity dan totalnya
                        item.quantity++;
                        item.total = item.price * item.quantity;
                        this.quantity++;
                        this.total += item.price;
                        return item;
                    }
                });
            }
        },
        remove(id) {
            // Ambil item yang mau diremove berdasarkan id nya
            const cartItem = this.items.find((item) => item.id === id);

            // Jika item lebih dari 1
            if(cartItem.quantity > 1) {
                // Telusrui Satu satu
                this.items = this.items.map((item) => {
                    // Jika bukan barang yang dklik
                    if(item.id !== id) {
                        return item;
                    } else {
                        item.quantity--;
                        item.total = item.price * item.quantity;
                        this.quantity--;
                        this.total -= item.price;
                        return item
                    }
                })
            }  else if (cartItem.quantity === 1) {
                this.items = this.items.filter((item) => item.id !== id);
                this.quantity--;
                this.total -= cartItem.price;
            }
        },
    });

    function updateCartDisplay() {
        // Select your cart DOM elements and update them accordingly
        const cartItemsContainer = document.querySelector('.shopping-cart .cart-items');
        const cartTotalElement = document.querySelector('.shopping-cart .total-price');
        
        // Clear the current display
        cartItemsContainer.innerHTML = '';
        
        // Rebuild the cart items display
        cart.items.forEach((item, index) => {
            const cartItemDiv = document.createElement('div');
            cartItemDiv.classList.add('cart-item');
            
            cartItemDiv.innerHTML = `
                <img src="img/${item.img}" alt="${item.name}">
                <div class="item-detail">
                    <h3>${item.name}</h3>
                    <div class="item-price">
                        <span>${rupiah(item.price)}</span> &times;
                        <button onclick="removeFromCart('${item.name}')">&minus;</button>
                        <span>${item.quantity}</span>
                        <button onclick="addToCart('${item.name}', ${item.price})">&plus;</button> &equals;
                        <span>${rupiah(item.total)}</span>
                    </div>
                </div>
            `;
            
            cartItemsContainer.appendChild(cartItemDiv);
        });
        
        // Update total price display
        cartTotalElement.textContent = `Total : ${rupiah(cart.total)}`;
    }
    
    // Helper function to format price
    function rupiah(price) {
        return `Rp. ${price},00`;
    }
    
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