<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yap Mei Tong</title>
    <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"  integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="adminAboutMe.css">


</head>
<body>
    <main>
        <button class="back-to-login" onclick="window.location.href='../index.php'">
            <i class="fa-solid fa-angles-left"></i> Back to Login
        </button>

        <div class="about-me-content about-me">
            <div class="profile-picture">
                <img src="profile_member_1.jpeg" alt="Profile Picture of Member 1">
            </div>
            <div class="info">
                <p>Yap Mei Tong</p>
                <div class="contact">
                    <p><i class="fa-solid fa-square-phone"></i> Phone: +6011 1111 1111</p>
                    <p><i class="fa-solid fa-envelope"></i> Email: yap@example.com</p>
                </div>
                <p class="intro">
                    I am a Diploma in ICT (DI) student at Asia Pacific University (APU) with a focus on <strong>web development</strong>, 
                    combining frontend design, backend logic, and database-driven solutions. I have experience 
                    building responsive, user-friendly applications using HTML, CSS, JavaScript, PHP, 
                    and MySQL.
                </p>
            </div>

            <div class="education section" >
                <p>Education</p>
                <div class="education-info">
                    <div style="display:flex; justify-content: space-between;">
                        <h3>Asia Pacific University of Technology & Innovation | Bukit Jalil, KL</h3>
                        <h4>2024 - Present</h4>
                    </div>
                    <ul>
                        <li> Diploma In Information and Communication Technology with Specialism in Data Informatics</li>
                        <li>Expected graduation year: MAY 2027</li>
                        <li>CGPA: 3.75 (Semester 1 - Semester 3)</li>
                    </ul>
                </div>
            </div>

            <div class="skill section" >
                <p>Skills</p>
                <div class="skill-info">
                    <ul>
                        <li><strong>Programming Languages:</strong> Python, Java</li>
                        <li><strong>Databases & Data Management:</strong> MySQL, MSSQL</li>
                        <li><strong>Web Development:</strong> HTML, CSS, PHP, JavaScript</li>
                        <li><strong>Data Analytics & Visualization:</strong> Microsoft Excel, RapidMiner</li>
                        <li><strong>Languages:</strong> Chinese, Cantonese, English, Malay, Hakka</li>
                    </ul>
                </div>
            </div>

            <div class="project section">
                <p>Projects</p>
                <div class="Project-info">
                    <div class="project-box">
                        <p>Tuition Centre Management System (Python)</p>
                        <ul>
                            <li>Managed the Receptionist role, overseeing student records, enrollment, subject changes, and payments.</li>
                            <li>Implemented role-based login and authentication for multiple users (Admin, Receptionist, Tutor, Student).</li>
                            <li>Used a text-file-based database to store all data, simulating a real database system.</li>
                            <li>Organized the system with functions for login, CRUD operations, payment processing, and profile management, ensuring modularity and maintainability.</li>
                        </ul>
                    </div>

                    <div class="project-box">
                        <p>Hospital Management System (Java Swing)</p>
                        <ul>
                            <li>Managed the Admin role, handling multiple modules: patients, staff (doctors/nurses), inventory, prescriptions, programs, and policies.</li>
                            <li>Implemented robust role-based login and authentication for Admin, Doctor, Nurse, and Patient users.</li>
                            <li>Used text-file-based storage for all modules, simulating a database while supporting cross-file operations and auto-generated IDs.</li>
                            <li>Designed modular OOP classes with validation, CRUD methods, prescription dispensing, stock tracking, and program/policy management for maintainable and scalable code.</li>
                        </ul>
                    </div>


                    <div class="project-box">
                        <p>Parking Violation Data Analysis & Prediction (RapidMiner)</p>
                        <ul>
                            <li>Analyzed parking violation data to uncover trends, patterns, and high-risk areas using RapidMiner.</li>
                            <li>Performed data cleaning, preprocessing, and exploratory data analysis (EDA) on real-world datasets.</li>
                            <li>Built predictive models using <strong>Gradient Boosting</strong> to forecast parking violations and identify potential hotspots.</li>
                            <li>Visualized insights and predictions with charts and dashboards to support data-driven decision making.</li>
                        </ul>
                    </div>
                                        
                </div>
            </div>


        </div>

    </main>
</body>
</html>