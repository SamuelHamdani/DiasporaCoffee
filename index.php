<?php
    require "koneksi.php";
    $queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
        rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/style.css">
    <title>Document</title>

    <!-- Javascript -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="/JS/app.js" async></script>
</head>

<body>

    <!-- Navbar start -->
    <nav class="navbar" x-data>
        <a href="#" class="navbar-logo">Diaspora <span>Coffee.</span></a>

        <div class="navbar-nav">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#menu">Menu</a>
            <a href="#products">Produk</a>
            <a href="#contact">Contact</a>
        </div>

        <div class="navbar-extra">
            <a href="#" id="search-button">
                <i data-feather="search"></i>
            </a>
            <a href="#" id="shopping-cart-button">
                <i data-feather="shopping-cart"></i>
                <span class="quantity-badge" x-show="$store.cart.quantity" x-text="$store.cart.quantity"></span>
            </a>
            <a href="#" id="nav-menu">
                <i data-feather="menu"></i>
            </a>
        </div>

        <!-- Seacrh Form Start -->
        <div class="search-form">
            <input type="search" name="" id="search-box" placeholder="search here...">
            <label for="search-box"><i data-feather="search"></i></label>
        </div>

        <!-- Shopping Cart -->
        <div class="shopping-cart">
            <template x-for="(item, index) in $store.cart.items" x-keys="index">
                <div class="cart-item">
                <img :src="`img/${item.img}`" :alt="item.name">
                <div class="item-detail">
                    <h3 x-text="item.name"></h3>
                    <div class="item-price">
                        <span x-text="rupiah(item.price)"></span> &times;
                        <button id="remove" @click="$store.cart.remove(item.id)">&minus;</button>
                        <span x-text="item.quantity"></span>
                        <button id="add" @click="$store.cart.add(item)">&plus;</button> &equals;
                        <span x-text="rupiah(item.total)"></span>
                    </div>
                </div>
                </div>
            </template>
            <h4 x-show="!$store.cart.items.length" style="margin-top: 1rem;">Cart Is Empty</h4>
            <h4 x-show="$store.cart.items.length">Total : <span x-text="rupiah($store.cart.total)"></span></h4>

            <div class="form-container" x-show="$store.cart.items.length">
                <form action="" id="checkoutForm">
                    <input type="hidden" name="items" x-model ="JSON.stringify($store.cart.items)">
                    <input type="hidden" name="total" x-model ="$store.cart.total">
                    <h5>Customer Detail</h5>

                    <label for="name">
                        <span>Name</span>
                        <input type="text" name="name" id="name" required>
                    </label>
                    <label for="email">
                        <span>Email</span>
                        <input type="email" name="email" id="email" required>
                    </label>
                    <label for="phone">
                        <span>Phone</span>
                        <input type="number" name="phone" id="phone" autocomplete="off" required>
                    </label>

                    <button class="checkout-button" type="submit" id="checkout-button" value="Checkout">Checkout</button>
                </form>
            </div>
        </div>

    </nav>
    <!-- Navbar end -->

    <!-- Hero Section Start -->
    <section class="hero" id="home">
        <main class="content">
            <h1>Mari Nikmati Segelas <span>Kopi</span></h1>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatum, saepe?</p>

        </main>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <h2>Tentang Kami</h2>

        <div class="row">
            <div class="about-img">
                <img src="img/Kopi (2).jpg" alt="Tentang Kami">
            </div>
            <div class="content">
                <h3>Kenapa memilih kopi Kami?</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A, incidunt.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti quae hic nulla eveniet, ipsam
                    voluptates.</p>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products" id="products">
        <h2>Our Products</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Possimus, exercitationem!</p>

        <div class="row">
        <?php while($data = mysqli_fetch_array($queryProduk)) { ?>
            <div class="product-card">
                <div class="product-icon">
                    <!-- Use onclick event to add item to cart -->
                    <a href="#" onclick="addToCart('<?php echo htmlspecialchars($data['nama']); ?>', <?php echo $data['harga']; ?>)">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <use href="img/feather-sprite.svg#shopping-cart"></use>
                        </svg>
                    </a>
                    <a href="#" class="item-detail-button">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <use href="img/feather-sprite.svg#eye"></use>
                        </svg>
                    </a>
                </div>
                <div class="product-image">
                    <img src="image/<?php echo $data['foto']; ?>" alt="">
                </div>
                <div class="product-content">
                    <h3><?php echo $data['nama']; ?></h3>
                    <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
                    <div class="product-price">
                        <span class="card-text text-harga">Rp. <?php echo $data['harga']; ?>,00</span>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <h2><span>Kontak</span> Kami</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos, porro.</p>

        <div class="row">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d294.73097652866505!2d106.73656382691846!3d-6.340710175057115!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ef9d2277e4bb%3A0x4d39e187dacc129!2sJl.%20Pamulang%20Permai%207%20Ib%20Blok%20B17%20No.10%2C%20RT.1%2FRW.15%2C%20Pamulang%20Bar.%2C%20Kec.%20Pamulang%2C%20Kota%20Tangerang%20Selatan%2C%20Banten%2015417!5e0!3m2!1sen!2sid!4v1712735803710!5m2!1sen!2sid"
                class="map" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <form onsubmit="sendToWhatsApp(event)">
                <div class="input-group">
                    <i data-feather="user"></i>
                    <input type="text" name="name" id="contactName" placeholder="Nama Anda" required>
                </div>
                <div class="input-group">
                    <i data-feather="mail"></i>
                    <input type="email" name="email" id="contactEmail" placeholder="Email Anda" required>
                </div>
                <div class="input-group">
                    <i data-feather="phone"></i>
                    <input type="text" name="phone" id="contactPhone" placeholder="Nomor HP" required>
                </div>
                <div class="input-group">
                    <i data-feather="message-circle"></i>
                    <textarea name="pesan" id="contactPesan" cols="100%" rows="5" placeholder="Pesan Anda" required></textarea>
                </div>
                <button type="submit" class="btn">Kirim Pesan</button>
            </form>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="social">
            <a href="#"><i data-feather="instagram"></i></a>
            <a href="#"><i data-feather="twitter"></i></a>
            <a href="#"><i data-feather="facebook"></i></a>
        </div>

        <div class="links">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#menu">Menu</a>
            <a href="#contact">Contact</a>
        </div>

        <div class="credit">
            <p>Created by <a href="">Samuel Hamdani</a>. &copy 2024</p>
        </div>
    </footer>

    <!-- Modal Box Item Detail-->
    <div class="modal" id="item-detail-modal">
        <div class="modal-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="modal-content">
                <img src="img/products/product.jpg" alt="Product 1">
                <div class="product-content">
                    <h3>Product 1</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima, deleniti fugit soluta sunt quod aliquid, ex repellat illo, doloribus dolorum rem ipsum veniam. Sed, hic.</p>
                    <div class="product-stars">
                        <i data-feather="star" class="star-full"></i>
                        <i data-feather="star" class="star-full"></i>
                        <i data-feather="star" class="star-full"></i>
                        <i data-feather="star" class="star-full"></i>
                        <i data-feather="star"></i>
                    </div>
                    <div class="product-price">
                        IDR 30K <span>IDR 55K</span>
                    </div>
                    <a href="#"><i data-feather="shopping-cart"></i>Add To Cart</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Feather Icons -->
    <script>
        feather.replace();
    </script>

    <!-- Javascript -->
    <script src="JS/script.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function sendToWhatsApp(event) {
                event.preventDefault();

                const name = document.getElementById("contactName").value;
                const email = document.getElementById("contactEmail").value;
                const phone = document.getElementById("contactPhone").value;
                const message = document.getElementById("contactPesan").value;

                console.log("Name:", name);
                console.log("Email:", email);
                console.log("Phone:", phone);
                console.log("Message:", message);

                const whatsappMessage = `Nama: ${name}%0AEmail: ${email}%0ANomor HP: ${phone}%0APesan: ${message}`;

                const whatsappUrl = `https://wa.me/6285219674120?text=${whatsappMessage}`;

                window.open(whatsappUrl, '_blank');
            }

            window.sendToWhatsApp = sendToWhatsApp;
        });
</script>
</body>

</html>