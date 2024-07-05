document.addEventListener('alpine:init', () => {
    Alpine.data('products', () => ({
        items: [],
    
        init() {
            fetch('get_produk.php')
                .then(response => response.json())
                .then(data => {
                    console.log('Received data:', data);
                    this.items = data.filter(item => item.stok === 'Tersedia');
                })
                .catch(error => console.error('Error:', error));
        },
    }));

    Alpine.store('cart', {
        items: [],
        total: 0,
        quantity: 0,
        
        add(newItem) {
            const cartItem = this.items.find(item => item.id === newItem.id);
        
            if (!cartItem) {
                this.items.push({...newItem, quantity: 1, total: newItem.harga});
            } else {
                cartItem.quantity++;
                cartItem.total = cartItem.harga * cartItem.quantity;
            }
        
            this.updateCart();
        },
        
        remove(id) {
            const index = this.items.findIndex(item => item.id === id);
        
            if (index !== -1) {
                const cartItem = this.items[index];
        
                if (cartItem.quantity > 1) {
                    cartItem.quantity--;
                    cartItem.total = cartItem.harga * cartItem.quantity;
                } else {
                    this.items.splice(index, 1);
                }
        
                this.updateCart();
            }
        },
        
        updateCart() {
            this.quantity = this.items.reduce((acc, item) => acc + item.quantity, 0);
            this.total = this.items.reduce((acc, item) => acc + item.total, 0);
        },
    });
});

// Form Validation
document.addEventListener('DOMContentLoaded', function() {
    const checkoutButton = document.querySelector('.checkout-button');
    checkoutButton.disabled = true;

    const form = document.querySelector('#checkoutForm');

    form.addEventListener('keyup', function() {
        for(let i = 0; i < form.elements.length; i++) {
            if(form.elements[i].value.length === 0) {
                checkoutButton.disabled = true;
                checkoutButton.classList.add('disabled');
                return;
            }
        }
        checkoutButton.disabled = false;
        checkoutButton.classList.remove('disabled');
    });
});

// Konversi mata uang ke Rupiah
const rupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(number);
}