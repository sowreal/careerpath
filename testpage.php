<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider's Arsenal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTTXVNhyvV1bv4eosM+BZpbgvzOQezV1Zk3tz+zXoI9X9AGr+78GkFw5DHTQqVUvEbeFwYh5Xg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- AOS CSS for Scroll Animations -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <!-- Animate.css for Additional Animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        /* Custom Styles */
        html {
            scroll-behavior: smooth;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
            transition: transform 0.3s;
        }
        .navbar-brand img:hover {
            transform: scale(1.1);
        }
        .hero-section {
            height: 100vh;
            position: relative;
            overflow: hidden;
        }
        .carousel-item {
            height: 100vh;
            min-height: 300px;
            background-size: cover;
            background-position: center;
            position: relative;
            color: white;
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            animation: fadeInUp 1s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .section-padding {
            padding: 60px 0;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 40px 0;
        }
        .footer a {
            color: #adb5bd;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer a:hover {
            color: #fff;
        }
        /* Hover Effects for Cards */
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        /* Team Member Image Hover */
        .team-img:hover {
            transform: scale(1.05);
            transition: transform 0.3s;
        }
        /* Button Hover Effect */
        .btn-primary {
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        /* Testimonials Animation */
        .testimonial-card {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease-out;
        }
        .testimonial-card.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>

    <!-- 1. Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="https://via.placeholder.com/40" alt="Logo">
                Rider's Arsenal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#why-us">Why Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#featured-products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about-us">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#footer">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 2. Hero Sliding Section -->
    <section id="hero" class="hero-section">
        <div id="heroCarousel" class="carousel slide h-100" data-bs-ride="carousel">
            <div class="carousel-inner h-100">
                <div class="carousel-item active h-100" style="background-image: url('https://via.placeholder.com/1920x1080');">
                    <div class="carousel-caption d-flex h-100 flex-column justify-content-center align-items-center text-center" data-aos="fade-up">
                        <h1 class="display-4 animate__animated animate__fadeInDown">Welcome to Rider's Arsenal</h1>
                        <p class="lead animate__animated animate__fadeInUp">Your one-stop shop for all your riding needs.</p>
                        <a href="#featured-products" class="btn btn-primary btn-custom animate__animated animate__fadeInUp">Shop Now</a>
                    </div>
                </div>
                <div class="carousel-item h-100" style="background-image: url('https://via.placeholder.com/1920x1080/555555');">
                    <div class="carousel-caption d-flex h-100 flex-column justify-content-center align-items-center text-center" data-aos="fade-up" data-aos-delay="200">
                        <h1 class="display-4 animate__animated animate__fadeInDown">Top Quality Gear</h1>
                        <p class="lead animate__animated animate__fadeInUp">Premium products to enhance your riding experience.</p>
                        <a href="#featured-products" class="btn btn-primary btn-custom animate__animated animate__fadeInUp">Explore Products</a>
                    </div>
                </div>
                <div class="carousel-item h-100" style="background-image: url('https://via.placeholder.com/1920x1080/333333');">
                    <div class="carousel-caption d-flex h-100 flex-column justify-content-center align-items-center text-center" data-aos="fade-up" data-aos-delay="400">
                        <h1 class="display-4 animate__animated animate__fadeInDown">Join Our Community</h1>
                        <p class="lead animate__animated animate__fadeInUp">Connect with riders around the world.</p>
                        <a href="#team" class="btn btn-primary btn-custom animate__animated animate__fadeInUp">Meet the Team</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- 3. Why Us Section -->
    <section id="why-us" class="section-padding bg-light">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Why Choose Us</h2>
            <div class="row g-4">
                <!-- Feature 1: Quality Products -->
                <div class="col-md-4 text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-star fa-3x mb-3 text-primary"></i>
                    </div>
                    <h4>Quality Products</h4>
                    <p>We offer only the highest quality gear to ensure your safety and comfort.</p>
                </div>
                <!-- Feature 2: Fast Shipping -->
                <div class="col-md-4 text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-shipping-fast fa-3x mb-3 text-primary"></i>
                    </div>
                    <h4>Fast Shipping</h4>
                    <p>Get your products delivered quickly and efficiently to your doorstep.</p>
                </div>
                <!-- Feature 3: 24/7 Support -->
                <div class="col-md-4 text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-headset fa-3x mb-3 text-primary"></i>
                    </div>
                    <h4>24/7 Support</h4>
                    <p>Our support team is available around the clock to assist you with any inquiries.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- 4. Our Featured Products Section -->
    <section id="featured-products" class="section-padding">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Our Featured Products</h2>
            <div class="row g-4">
                <!-- Product 1 -->
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Product 1">
                        <div class="card-body">
                            <h5 class="card-title">Product One</h5>
                            <p class="card-text">Description of Product One.</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary">Buy Now</a>
                        </div>
                    </div>
                </div>
                <!-- Product 2 -->
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Product 2">
                        <div class="card-body">
                            <h5 class="card-title">Product Two</h5>
                            <p class="card-text">Description of Product Two.</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary">Buy Now</a>
                        </div>
                    </div>
                </div>
                <!-- Product 3 -->
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Product 3">
                        <div class="card-body">
                            <h5 class="card-title">Product Three</h5>
                            <p class="card-text">Description of Product Three.</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary">Buy Now</a>
                        </div>
                    </div>
                </div>
                <!-- Add more products as needed -->
            </div>
        </div>
    </section>

    <!-- 5. Our Team Section -->
    <section id="team" class="section-padding bg-light">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Meet Our Team</h2>
            <div class="row g-4">
                <!-- Team Member 1 -->
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card text-center h-100">
                        <img src="https://via.placeholder.com/200" class="card-img-top rounded-circle mx-auto mt-3 team-img" alt="Team Member 1" style="width: 150px; height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">Alice Johnson</h5>
                            <p class="card-text">Founder & CEO</p>
                        </div>
                    </div>
                </div>
                <!-- Team Member 2 -->
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="card text-center h-100">
                        <img src="https://via.placeholder.com/200" class="card-img-top rounded-circle mx-auto mt-3 team-img" alt="Team Member 2" style="width: 150px; height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">Bob Smith</h5>
                            <p class="card-text">Head of Marketing</p>
                        </div>
                    </div>
                </div>
                <!-- Team Member 3 -->
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="card text-center h-100">
                        <img src="https://via.placeholder.com/200" class="card-img-top rounded-circle mx-auto mt-3 team-img" alt="Team Member 3" style="width: 150px; height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">Charlie Davis</h5>
                            <p class="card-text">Lead Developer</p>
                        </div>
                    </div>
                </div>
                <!-- Team Member 4 -->
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="card text-center h-100">
                        <img src="https://via.placeholder.com/200" class="card-img-top rounded-circle mx-auto mt-3 team-img" alt="Team Member 4" style="width: 150px; height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">Diana Prince</h5>
                            <p class="card-text">Customer Support</p>
                        </div>
                    </div>
                </div>
                <!-- Add more team members as needed -->
            </div>
        </div>
    </section>

    <!-- 6. About Us Section -->
    <section id="about-us" class="section-padding">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">About Us</h2>
            <div class="row align-items-center">
                <div class="col-md-6" data-aos="fade-right">
                    <img src="https://via.placeholder.com/500x300" class="img-fluid rounded mb-4 mb-md-0" alt="About Us Image">
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <p>Rider's Arsenal was founded with a passion for motorcycling and a commitment to providing riders with the best gear and accessories. Our mission is to enhance your riding experience by offering top-quality products, exceptional customer service, and a community where riders can connect and share their passion.</p>
                    <p>Whether you're a seasoned rider or just starting out, Rider's Arsenal has everything you need to ride safely and in style. Join us on our journey to make every ride unforgettable.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Client Testimonials Section -->
    <section id="testimonials" class="section-padding bg-light">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">What Our Clients Say</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Testimonial 1 -->
                    <div class="card mb-4 testimonial-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="card-body">
                            <p class="card-text">"Rider's Arsenal has the best selection of gear. Their products are top-notch and the customer service is outstanding!"</p>
                            <h5 class="card-title">- John Doe</h5>
                        </div>
                    </div>
                    <!-- Testimonial 2 -->
                    <div class="card mb-4 testimonial-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="card-body">
                            <p class="card-text">"I love the fast shipping and the quality of the products I received. Highly recommend Rider's Arsenal to all riders."</p>
                            <h5 class="card-title">- Jane Smith</h5>
                        </div>
                    </div>
                    <!-- Testimonial 3 -->
                    <div class="card mb-4 testimonial-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-body">
                            <p class="card-text">"Their team is knowledgeable and always ready to help. Rider's Arsenal is my go-to for all my riding needs."</p>
                            <h5 class="card-title">- Mike Johnson</h5>
                        </div>
                    </div>
                    <!-- Add more testimonials as needed -->
                </div>
            </div>
        </div>
    </section>

    <!-- 8. Footer Section -->
    <footer id="footer" class="footer">
        <div class="container">
            <div class="row g-4">
                <!-- Quick Links -->
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#hero">Home</a></li>
                        <li><a href="#why-us">Why Us</a></li>
                        <li><a href="#featured-products">Products</a></li>
                        <li><a href="#team">Team</a></li>
                        <li><a href="#about-us">About</a></li>
                        <li><a href="#testimonials">Testimonials</a></li>
                    </ul>
                </div>
                <!-- Subscribe to Mailing List -->
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <h5>Subscribe</h5>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </form>
                </div>
                <!-- Contact Us / Social Media -->
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <h5>Contact Us</h5>
                    <p>
                        123 Rider's Street<br>
                        City, State, ZIP<br>
                        Email: <a href="mailto:info@ridersarsenal.com">info@ridersarsenal.com</a><br>
                        Phone: <a href="tel:+11234567890">(123) 456-7890</a>
                    </p>
                </div>
                <!-- Social Media Icons -->
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                    <h5>Follow Us</h5>
                    <a href="#" class="me-3 text-decoration-none text-light"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" class="me-3 text-decoration-none text-light"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="#" class="me-3 text-decoration-none text-light"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#" class="text-decoration-none text-light"><i class="fab fa-linkedin fa-2x"></i></a>
                </div>
            </div>
            <hr class="my-4" style="border-color: #495057;">
            <div class="text-center">
                &copy; 2024 Rider's Arsenal. All Rights Reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies (Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS for Scroll Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <!-- Initialize AOS -->
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

        // Initialize Carousel with options
        var heroCarousel = document.querySelector('#heroCarousel');
        var carousel = new bootstrap.Carousel(heroCarousel, {
            interval: 5000,
            ride: 'carousel',
            pause: 'hover',
            wrap: true
        });
    </script>
</body>
</html>
