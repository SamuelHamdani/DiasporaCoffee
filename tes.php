<?php
    require "koneksi.php";
    $queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk");
    session_start();
    $_SESSION['cart'] = [];

    function addToCart($id, $name, $price, $image) {
        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'image' => $image,
                'quantity' => 1
            ];
        } else {
            $_SESSION['cart'][$id]['quantity']++;
        }
    }

    function displayCart() {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
            echo '
                <div class="cart-item">
                    <img src="' . $item['image'] . '" alt="' . $item['name'] . '">
                    <div class="item-detail">
                        <h3>' . $item['name'] . '</h3>
                        <div class="item-price">
                            <span>' . $item['price'] . '</span> &times;
                            <button onclick="updateCart(' . $item['id'] . ', -1)">-</button>
                            <span>' . $item['quantity'] . '</span>
                            <button onclick="updateCart(' . $item['id'] . ', 1)">+</button> &equals;
                            <span>' . $item['price'] * $item['quantity'] . '</span>
                        </div>
                    </div>
                </div>
            ';
        }
        echo '
            <h4>Total: ' . $total . '</h4>
        ';
    }

    function updateCart($id, $quantity) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
            if ($_SESSION['cart'][$id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
    }

    function removeProductFromCart($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="img/diaspora logo.png" rel='shortcun icon'>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
        rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <title>Diaspora Coffee</title>

    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.9.1/dist/cdn.min.js" defer></script>
    <script src="JS/app.js"></script>
</head>

<body>

    <!-- Navbar start -->
    <nav class="navbar" x-data>
        <a href="#" class="navbar-logo">Diaspora <span>Coffee.</span></a>

        <div class="navbar-nav">
            <a href="#home">Home</a>
            <a href="#about">About</a>
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
            <form method="get" action="produk.php">
            <input type="search" name="keyword" id="search-box" placeholder="search here...">
            <button type="submit"><i data-feather="search"></i></button>
            </form>
        </div>

        <!-- Shopping Cart -->
        <div class="shopping-cart">
            <?php displayCart();?>
        </div>

        <!-- Navbar End -->
    </nav>

    <!-- Hero Section Start -->
    <section class="hero" id="home">
        <h1>Welcome to Diaspora Coffee</h1>
        <p>Experience the best coffee in town</p>
        <button>Learn More</button>
    </section>

    <!-- About Section Start -->
    <section class="about" id="about">
        <h2>About Us</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet nulla auctor, vestibulum magna sed,
            convallis ex.</p>
        <button>Learn More</button>
    </section>

    <!-- Products Section Start -->
    <section class="products" id="products">
        <h2>Our Products</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet nulla auctor, vestibulum magna sed,
            convallis ex.</p>

        <div class="row">
            <?php
            require "koneksi.php";
            $queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk");
            while ($data = mysqli_fetch_array($queryProduk)) {
           ?>
            <div class="product-card">
                <div class="product-icon">
                    <a href="javascript:void(0)" onclick="addToCart(<?php echo $data['id'];?>, '<?php echo $data['nama'];?>', <?php echo $data['harga'];?>, '<?php echo $data['foto'];?>')">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <use href="img/feather-sprite.svg#shopping-cart"></use>
                        </svg>
                    </a>
                    <a href="#" class="item-detail-button">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <use href="img/feather-sprite.svg#eye"></use>
                        </svg>
                    </a>
                </div>
                <div class="product-image">
                    <img src="image/<?php echo $data['foto'];?>" alt="<?php echo $data['nama'];?>">
                </div>
                <div class="product-content">
                    <h3><?php echo $data['nama'];?></h3>
                    <p class="card-text text-truncate"><?php echo $data['detail'];?></p>
                    <div class="product-price">
                        <span class="card-text text-harga">Rp. <?php echo $data['harga'];?>,00</span>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </section>

    <!-- Contact Section Start -->
    <section class="contact" id="contact">
        <h2>Get in Touch</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet nulla auctor, vestibulum magna sed,
            convallis ex.</p>
        <button>Contact Us</button>
    </section>

    <!-- Footer Start -->
    <footer>
        <p>&copy; 2022 Diaspora Coffee. All rights reserved.</p>
    </footer>

    <!-- Feather Icons -->
    <script>
        feather.replace();
    </script>

</body>

</html>