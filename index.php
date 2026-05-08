<?php
include 'global/session.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RideShare@APU</title>

    <link rel="stylesheet" href="global/main.css">
    <link rel="stylesheet" href="global/header.css">
    <link rel="stylesheet" href="global/footer.css">
    <link rel="stylesheet" href="index.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.0/css/all.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bowlby+One&family=Ultra&display=swap" rel="stylesheet">
</head>
<body>
    <div id="landingPage">
        <?php include 'global/header.php'; ?>
        <div class="menu-overlay"></div>

        <!-- ===== Landing Page (Developed by Other Team Members) ===== -->
        <main class="benefit-landing">
            <section class="benefit-hero" id="hero">
                <div class="hero-grid">
                    <div class="hero-copy">
                        <p class="hero-kicker">RideShare@APU Transportation Services</p>
                        <h1 class="hero-title">Formal, reliable campus<br>ride-share overview</h1>
                        <p class="hero-subtitle">
                            A structured summary of the service scope, safety standards, and sustainability outcomes
                            designed for APU students, staff, and approved partners.
                        </p>
                        <div class="hero-actions">
                            <a onclick="showLoginPopup()" class="btn-primary" href="#loginPage">Get started</a>
                            <a class="btn-secondary" href="#services">View service standards</a>
                        </div>
                        <div class="hero-highlights">
                            <span class="hero-badge">Verified profiles</span>
                            <span class="hero-badge">Scheduled availability</span>
                            <span class="hero-badge">Sustainability reporting</span>
                        </div>
                    </div>
                    <div class="hero-card hero-image-card">
                        <img src="Landing.jpeg" alt="RideShare@APU campus ride-share cover" loading="lazy">
                    </div>
                </div>
            </section>

            <section class="benefit-section" id="services">
                <h2 class="section-title">Service standards and benefits</h2>
                <p class="section-subtitle">
                    Key commitments that define reliability, accountability, and cost efficiency across the program.
                </p>
                <div class="benefit-grid">
                    <article class="benefit-card">
                        <div class="benefit-tag">01</div>
                        <h4>Cost transparency</h4>
                        <p>Shared fares are published in advance with clear trip breakdowns.</p>
                    </article>
                    <article class="benefit-card">
                        <div class="benefit-tag" style="background: var(--clay);">02</div>
                        <h4>Sustainability tracking</h4>
                        <p>Environmental impact is measured and reported for program review.</p>
                    </article>
                    <article class="benefit-card">
                        <div class="benefit-tag" style="background: var(--sun); color: var(--forest);">03</div>
                        <h4>Verified participation</h4>
                        <p>Profiles are authenticated to preserve trust and community safety.</p>
                    </article>
                    <article class="benefit-card">
                        <div class="benefit-tag">04</div>
                        <h4>Structured scheduling</h4>
                        <p>Planned routes and availability reduce uncertainty for daily commutes.</p>
                    </article>
                </div>
            </section>

            <section class="benefit-section" id="workflow">
                <h2 class="section-title">Service workflow</h2>
                <p class="section-subtitle">Three clear steps from registration to ride completion.</p>
                <div class="steps">
                    <div class="step-item">
                        <div class="step-count">1</div>
                        <div>
                            <strong>Register an account</strong>
                            <p>Authenticate with APU credentials for eligibility review.</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-count">2</div>
                        <div>
                            <strong>Select or offer a route</strong>
                            <p>Publish or request rides within the approved service zones.</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-count">3</div>
                        <div>
                            <strong>Confirm completion</strong>
                            <p>Trip records update savings and sustainability reporting.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="cta-section" id="cta">
                <h3>Ready to begin enrollment?</h3>
                <p>Request access or contact our team for service documentation and assistance.</p>
                <div class="hero-actions">
                    <a class="btn-primary" href="index.php">Submit a request</a>
                    <a class="btn-secondary" href="#contact">Contact support</a>
                </div>
            </section>
        </main>

        <?php include 'global/footer.php'; ?>
    </div>


    <div id="loginPage">
        <div class="login-container">
            <div class="close"><i class="fa-solid fa-xmark"></i></div>

            <div class="login form">
                <h1>Login</h1>
                <form id="login-form" action="validateLogin.php" method="POST">
                    <input type="text" placeholder="Username" name="txtUsername" >
                    <input type="password" placeholder="Password" name="txtPassword" >

                    <div class="login-error-message"></div>

                    <button type="submit" value="loginForm" name="btnLogin" >Login</button>
                </form>
            </div>


            <div class="register form">
                <h1>Registration</h1>

                <form method="POST">

                    <div class="field-container">
                        <input type="text" name="username" placeholder="Username" required>
                        <div class="error" data-error-for="username"></div>
                    </div>

                    <div class="field-container">
                        <input type="password" name="password" placeholder="Password" required>
                        <div class="error" data-error-for="password"></div>
                    </div>

                    <div class="field-container">
                        <input type="text" name="fullName" placeholder="Full Name" required>
                        <div class="error" data-error-for="fullName"></div>
                    </div>

                    <div class="field-container">
                        <input type="text" name="ic" placeholder="IC / Passport" required>
                        <div class="error" data-error-for="ic"></div>
                    </div>

                    <div class="field-container">
                        <input type="text"
                            name="contact"
                            placeholder="Contact Number (e.g. 0111234567)"
                            inputmode="numeric"
                            required>
                        <div class="error" data-error-for="contact"></div>
                    </div>

                    <div class="field-container">
                        <input type="email" name="email" placeholder="Email Address" required>
                        <div class="error" data-error-for="email"></div>
                    </div>

                    <div class="field-container">
                        <div class="gender">
                            <label>
                                <input type="radio" name="gender" value="male"> Male
                            </label>
                            <label>
                                <input type="radio" name="gender" value="female"> Female
                            </label>
                        </div>
                        <div class="error" data-error-for="gender"></div>
                    </div>

                    <div class="field-container">
                        <div class="date">
                            <label>Date of Birth:</label>
                            <input type="date" name="dob" required>
                        </div>
                        <div class="error" data-error-for="dob"></div>
                    </div>

                    <button type="submit" name="btnRegister">Register</button>

                </form>
            </div>

            
            <div class="driver-register form">
                <h1>Driver Registration</h1>
                <form method="POST">
                    <div class="driver-registration-grid">
                        <div class="field-container">
                            <div class="file">
                                <label>Profile Image: </label>
                                <input type="file" name="request_profile_image">
                            </div>
                        </div>

                        <div class="field-container">
                            <input type="text" name="request_name" placeholder="Full Name" >
                        </div>

                        <div class="field-container">
                            <input type="text" name="request_ic_passport" placeholder="IC / Passport" >
                        </div>

                        <div class="field-container">
                            <input type="tel" name="request_contact" placeholder="Contact Number (E.g., 011-11111111)" >
                        </div>

                        <div class="field-container">
                            <input type="email" name="request_email" placeholder="Email Address" >
                        </div>

                        <div class="field-container">
                            <div class="gender">
                                <label><input type="radio" name="request_gender" value="MALE">MALE</label>
                                <label><input type="radio" name="request_gender" value="FEMALE">FEMALE</label>
                            </div>
                        </div>

                        <div class="field-container">
                            <div class="date">
                                <label>Date of Birth:</label>
                                <input type="date" name="request_dob">
                            </div>
                        </div>

                        <div class="field-container">
                            <input type="text" name="request_plate_no" placeholder="Vehicle Plate Number (E.g., XYZ123)">
                        </div>
                        
                        <div class="field-container">
                            <input type="text" name="request_vehicle_model" placeholder="Vehicle Model (e.g., Perodua Myvi 2024)">
                        </div>

                        <div class="field-container">
                            <input type="text" name="request_vehicle_color" placeholder="Vehicle Color">
                        </div>

                        <div class="field-container">
                            <div class="file"> 
                                <label>Vehicle Image: </label>
                                <input type="file" name="request_vehicle_image">
                            </div>
                        </div>

                        <div class="field-container">
                            <div class="file"> 
                                <label>License Image: </label>
                                <input type="file" name="request_license_image">
                            </div>
                        </div>

                        <div class="field-container">
                            <div class="date">
                                <label>License Expiry:</label>
                                <input type="date" name="request_license_expiry">
                            </div>
                        </div>

                        <div class="field-container">
                            <div class="file"> 
                                <label>Road Tax Image: </label>
                                <input type="file" name="request_road_tax_image">
                            </div>
                        </div>

                        <div class="field-container">
                            <div class="date">
                                <label>Road Tax Expiry:</label>
                                <input type="date" name="request_road_tax_expiry">
                            </div>
                        </div>

                    </div>
                    <div id="driverRequestButton">
                        <button type="submit" name="register_driver">Register</button>
                    </div>
                </form>
            </div>

            <div class="slider">
                <div class="backToRegister">
                    <i onclick="closeDriverRegister()" class="fa-solid fa-circle-arrow-left"></i>
                </div>
                <div class="slide left">
                    <h2>Join us today!</h2>
                    <a class="hide" onclick="openDriverRegister()">Become a driver</a> 
                    <p class="hide" class="divider">or</p>
                    <p class="hide" >Already have an account?</p>
                    <button class="hide" onclick="showLogin()">Login</button> 
                </div>
                <div class="slide right">
                    <h2>Good to see you again!</h2>
                    <p>Do not have an account?</p>
                    <button onclick="showRegister()">Register</button>
                </div>
            </div>       
            
        </div>

    </div>

    <script src="global/main.js"></script>
    <script>
        
        //My contribution
        //clear error message after model closed
        document.addEventListener("DOMContentLoaded", () => {
            const closeBtn = document.querySelector(".close i");

            if (!closeBtn) return;

            closeBtn.addEventListener("click", () => {
                closeLoginPopup();

                document.querySelectorAll('.error-message, .error')
                    .forEach(el => el.textContent = '');

                document.querySelector(".login-error-message").textContent = "";
            });
        });


        //login validation js
        document.getElementById("login-form").addEventListener("submit", function (e) {
            e.preventDefault(); 

            const errorDiv = document.querySelector('.login-error-message');
            errorDiv.textContent = "";

            fetch("validateLogin.php", {method: "POST",body: new FormData(this)})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;          
                } else {
                    errorDiv.textContent = data.login;
                }
            })
            .catch(err => {
                console.error("Fetch error:", err);
                alert('Network error. Please try again later.');
            });
        });



        //menu highlight
        document.addEventListener("DOMContentLoaded", function() {
            const sections = document.querySelectorAll("main section[id]");
            const menuLinks = document.querySelectorAll("header .desktopNavi ul li a, header .mobileNavi ul li a");

            function activateMenu() {
                let scrollY = window.pageYOffset;

                sections.forEach(section => {
                    const sectionHeight = section.offsetHeight;
                    const sectionTop = section.offsetTop - 80; 
                    const sectionId = section.getAttribute("id");

                    if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                        menuLinks.forEach(link => {
                            link.classList.remove("active");
                            if (link.getAttribute("href").includes(sectionId)) {
                                link.classList.add("active");
                            }
                        });
                    }
                });
            }
            window.addEventListener("scroll", activateMenu);
            activateMenu(); 
        });


        //mobile mode menu close
        document.querySelector('.menu-overlay').addEventListener('click', () => {   
            closeMenu('mobileNavi'); 
        });

        
    </script>
</body>
</html>