<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #640908;
            text-decoration: none;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #640908;
        }

        .nav-cta {
            background: linear-gradient(135deg, #640908 0%, #8b0a0b 100%);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(100, 9, 8, 0.3);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            background-image: url("assets/herobackground.jpg");
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            max-width: 800px;
            z-index: 2;
            position: relative;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-cta {
            display: inline-flex;
            gap: 1rem;
        }

        .btn-primary {
            background: white;
            color: #640908;
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            padding: 1rem 2rem;
            border: 2px solid white;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: white;
            color: #640908;
        }

        /* Features Section */
        .features {
            padding: 100px 2rem;
            background: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #640908 0%, #8b0a0b 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }

        .feature-description {
            color: #666;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats {
            padding: 100px 2rem;
            background: linear-gradient(135deg, #640908 0%, #8b0a0b 100%);
            color: white;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }

        .stat-item {
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Testimonials Section */
        .testimonials {
            padding: 100px 2rem;
            background: #fff;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .testimonial-card {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 20px;
            position: relative;
            border-left: 4px solid #640908;
        }

        .testimonial-content {
            font-style: italic;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #640908 0%, #8b0a0b 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .author-info h4 {
            color: #333;
            margin-bottom: 0.25rem;
        }

        .author-info p {
            color: #666;
            font-size: 0.9rem;
        }

        /* CTA Section */
        .cta-section {
            padding: 100px 2rem;
            background: linear-gradient(135deg, #000000 0%, #640908 100%);
            color: white;
            text-align: center;
        }

        .cta-content {
            max-width: 600px;
            margin: 0 auto;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            background: #1a1a1a;
            color: #ccc;
            padding: 3rem 2rem 1rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-section h3 {
            color: white;
            margin-bottom: 1rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section ul li a:hover {
            color: #640908;
        }

        .footer-bottom {
            border-top: 1px solid #333;
            margin-top: 2rem;
            padding-top: 1rem;
            text-align: center;
            color: #666;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .mobile-menu-toggle span {
            width: 25px;
            height: 3px;
            background: #333;
            margin: 3px 0;
            transition: 0.3s;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
            }

            .nav-menu {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background: white;
                flex-direction: column;
                justify-content: start;
                align-items: center;
                padding-top: 2rem;
                transition: left 0.3s ease;
            }

            .nav-menu.active {
                left: 0;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .features-grid,
            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .nav-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">
                <div class="logo-container">
                    <img src="assets/Logo.svg" alt="Brand Logo" style="height:40px; vertical-align:middle;">
                    VANTA VOYAGE
                </div>
            </a>
            <ul class="nav-menu">
                <li><a href="#home" class="nav-link">Home</a></li>
                <li><a href="#features" class="nav-link">Features</a></li>
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#testimonials" class="nav-link">Testimonials</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
                <li><a href="#" class="nav-cta">Get Started</a></li>
            </ul>
            <div class="mobile-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Trojan's Herald | Vanta Voyage</h1>
            <h2>March of the New Bloods</h2>
            <p>Get ready, freshmen and transferees! Our March of the New Bloods begins now.</p>
            <div class="hero-cta">
                <a href="#" class="btn-primary">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
    <div class="container">
        <div class="section-header">
        <h2 class="section-title">Main Events</h2>
        <p class="section-subtitle">Fueling competition with rock energy</p>
        </div>
        <div class="features-grid">
        
        <!-- Feature 1 -->
        <div class="feature-card">
            <div class="feature-image">
            <img src="assets/event1.jpg" alt="Event 1" style="width: 100%; height: 100%; object-fit: fill; top: 0; left: 0; border-radius: 12px;">
            </div>
            <h3 class="feature-title">Battle of the Bands</h3>
            <p class="feature-description">
            Feel the energy as student bands clash on stage, bringing raw talent and rock spirit.
            </p>
        </div>
        
        <!-- Feature 2 -->
        <div class="feature-card">
            <div class="feature-image">
            <img src="assets/event2.jpg" alt="Event 2" style="width: 100%; height: 100%; object-fit: fill; top: 0; left: 0; border-radius: 12px;">
            </div>
            <h3 class="feature-title">Mr. and Ms. Vanta Voyage</h3>
            <p class="feature-description">
            Witness the rise of talent and charisma as students compete for the crown.
            </p>
        </div>
        
        <!-- Feature 3 -->
        <div class="feature-card">
            <div class="feature-image">
            <img src="assets/event3.jpg" alt="Event 3" style="width: 100%; height: 100%; object-fit: fill; top: 0; left: 0; border-radius: 12px;">
            </div>
            <h3 class="feature-title">Freshmen Showcase</h3>
            <p class="feature-description">
            A spotlight for new bloods to introduce themselves through performances and creativity.
            </p>
        </div>

        </div>
    </div>
    </section>


    <!-- Stats Section -->
    <section class="stats">
    <div class="container">
        <div class="section-header">
        <h2 class="section-title">Vanta Voyage in Numbers</h2>
        <p class="section-subtitle">Celebrating the spirit of unity, talent, and competition</p>
        </div>
        <div class="stats-grid">
        <div class="stat-item">
            <div class="stat-number">500+</div>
            <div class="stat-label">Freshmen & Transferees</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">20+</div>
            <div class="stat-label">Student Organizations</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">15+</div>
            <div class="stat-label">Main Events</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">1</div>
            <div class="stat-label">Unforgettable Journey</div>
        </div>
        </div>
    </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials">
    <div class="container">
        <div class="section-header">
        <h2 class="section-title">What Students Say</h2>
        <p class="section-subtitle">First-hand voices from past participants</p>
        </div>
        <div class="testimonials-grid">
        <div class="testimonial-card">
            <p class="testimonial-content">"Vanta Voyage gave me the chance to connect with my peers and discover organizations I never knew existed. It’s the best start to my college life."</p>
            <div class="testimonial-author">
            <div class="author-avatar">AL</div>
            <div class="author-info">
                <h4>Ana Lopez</h4>
                <p>First-Year Student</p>
            </div>
            </div>
        </div>
        <div class="testimonial-card">
            <p class="testimonial-content">"The energy during the competitions was electric. March of the New Bloods truly makes you feel part of something bigger."</p>
            <div class="testimonial-author">
            <div class="author-avatar">RM</div>
            <div class="author-info">
                <h4>Ramon Morales</h4>
                <p>Student Athlete</p>
            </div>
            </div>
        </div>
        <div class="testimonial-card">
            <p class="testimonial-content">"I’ll never forget the Mr. and Ms. Vanta Voyage pageant. It was inspiring to see my fellow students showcase their talents."</p>
            <div class="testimonial-author">
            <div class="author-avatar">KC</div>
            <div class="author-info">
                <h4>Kaye Cruz</h4>
                <p>Organization Member</p>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>


    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Product</h3>
                <ul>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Security</a></li>
                    <li><a href="#">Integrations</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Company</h3>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Resources</h3>
                <ul>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">API Reference</a></li>
                    <li><a href="#">Community</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Legal</h3>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                    <li><a href="#">GDPR</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Brand. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const navMenu = document.querySelector('.nav-menu');

        mobileMenuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>