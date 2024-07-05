<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diaspora Coffee</title>
    <link href="img/diaspora logo.png" rel='shortcun icon'>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
         rel="stylesheet">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="CSS/style.css">

    <!-- Javascript -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="/JS/app.js" async></script>
</head>
<body>
    <!-- Navbar start -->
    <nav class="navbar" x-data>
        <a href="#" class="navbar-logo">Diaspora <span>Coffee.</span></a>

        <div class="navbar-nav">
            <a href="./main.php">Home</a>
            <a href="./main.php#about">About</a>
            <a href="./main.php#products">Product</a>
        </div>

        <div class="navbar-extra">
            <a href="#" id="nav-menu">
                <i data-feather="menu"></i>
            </a>
        </div>
    </nav>
    <!-- Navbar end -->

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <h2><span>Kontak</span> Kami</h2>

        <div class="row">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d294.73097652866505!2d106.73656382691846!3d-6.340710175057115!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ef9d2277e4bb%3A0x4d39e187dacc129!2sJl.%20Pamulang%20Permai%207%20Ib%20Blok%20B17%20No.10%2C%20RT.1%2FRW.15%2C%20Pamulang%20Bar.%2C%20Kec.%20Pamulang%2C%20Kota%20Tangerang%20Selatan%2C%20Banten%2015417!5e0!3m2!1sen!2sid!4v1712735803710!5m2!1sen!2sid"
                class="map" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <form onsubmit="sendToWhatsApp(event)">
                <div class="input-group">
                    <i data-feather="user"></i>
                    <input type="text" name="name" id="name" placeholder="Nama Anda" required>
                </div>
                <div class="input-group">
                    <i data-feather="mail"></i>
                    <input type="email" name="email" id="email" placeholder="Email Anda" required>
                </div>
                <div class="input-group">
                    <i data-feather="phone"></i>
                    <input type="text" name="phone" id="phone" placeholder="Nomor HP" required>
                </div>
                <div class="input-group">
                    <i data-feather="message-circle"></i>
                    <textarea name="pesan" id="pesan" cols="100%" rows="5" placeholder="Pesan Anda" required></textarea>
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
            <a href="/index.html">Home</a>
            <a href="/index.html#about">About</a>
            <a href="/index.html#products">Product</a>
        </div>

        <div class="credit">
            <p>Created by <a href="">Samuel Hamdani</a>. &copy 2024</p>
        </div>
    </footer>

    <!-- Feather Icons -->
    <script>
        feather.replace();
    </script>

    <!-- Javascript -->
    <script>
        function sendToWhatsApp(event) {
            event.preventDefault();

            const name = document.getElementById("name").value;
            const email = document.getElementById("email").value;
            const phone = document.getElementById("phone").value;
            const message = document.getElementById("pesan").value;

            const whatsappMessage = `Nama: ${name}%0AEmail: ${email}%0ANomor HP: ${phone}%0APesan: ${message}`;

            const whatsappUrl = `https://wa.me/6285219674120?text=${whatsappMessage}`;

            window.open(whatsappUrl, '_blank');
        }
    </script>
</body>
</html>
