<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>FAC Election | Student Union Election Management System</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>


*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:"Segoe UI", Arial, Helvetica, sans-serif;
    background:#f5f8fc;
    color:#1f2937;
}


.navbar-custom{
    background:#075386;
    padding:15px 6%;
    box-shadow:0 3px 15px rgba(0,0,0,0.12);
}


.logo{
    color:white !important;
    font-size:25px;
    font-weight:700;
    text-decoration:none;

    display:flex;
    align-items:center;

    gap:10px;
}


.university-logo{
    width:48px;
    height:48px;

    object-fit:contain;

    background:white;

    border-radius:50%;

    padding:4px;
}


.logo-text{
    display:flex;
    flex-direction:column;
    line-height:1.1;
}


.logo-title{
    font-size:24px;
    font-weight:700;
}


.logo-subtitle{
    font-size:11px;
    font-weight:400;
    opacity:0.85;
}


.nav-link{
    color:white !important;

    font-size:16px;

    margin:0 8px;

    font-weight:500;

    transition:0.3s;
}


.nav-link:hover{
    color:#ffc107 !important;
}


.student-btn{
    background:#ffc107;

    color:#111 !important;

    border:none;

    padding:10px 20px;

    border-radius:8px;

    font-size:15px;

    font-weight:700;

    text-decoration:none;

    transition:0.3s;
}


.student-btn:hover{
    background:#ffca2c;

    transform:translateY(-2px);
}

.admin-btn{
    background:white;

    color:#075386 !important;

    border:none;

    padding:10px 20px;

    border-radius:8px;

    font-size:15px;

    font-weight:700;

    text-decoration:none;

    transition:0.3s;
}


.admin-btn:hover{
    background:#f1f5f9;

    transform:translateY(-2px);
}


.hero{
    min-height:calc(100vh - 78px);

    display:flex;

    align-items:center;

    position:relative;

    overflow:hidden;

    background:
        linear-gradient(
            135deg,
            #075386 0%,
            #0b6da8 55%,
            #3f7199 100%
        );

    color:white;
}


.hero::before{
    content:"";

    position:absolute;

    width:400px;
    height:400px;

    border-radius:50%;

    background:rgba(255,255,255,0.06);

    top:-180px;
    right:-100px;
}


.hero::after{
    content:"";

    position:absolute;

    width:300px;
    height:300px;

    border-radius:50%;

    background:rgba(255,193,7,0.08);

    bottom:-150px;
    left:-100px;
}


.hero-content{
    position:relative;

    z-index:2;

    width:100%;
}


.hero-text{
    padding:30px 10px;
}


.badge-election{
    display:inline-block;

    background:rgba(255,255,255,0.15);

    border:1px solid rgba(255,255,255,0.25);

    padding:8px 16px;

    border-radius:30px;

    font-size:14px;

    font-weight:600;

    margin-bottom:20px;
}


.hero h1{
    font-size:52px;

    line-height:1.15;

    font-weight:800;

    margin-bottom:20px;
}


.hero h1 span{
    color:#ffc107;
}


.hero-subtitle{
    font-size:21px;

    line-height:1.7;

    color:rgba(255,255,255,0.9);

    margin-bottom:8px;
}


.hero-description{
    font-size:16px;

    color:rgba(255,255,255,0.75);

    max-width:600px;

    line-height:1.7;

    margin-top:20px;
}


.login-card{
    background:white;

    border-radius:20px;

    padding:35px;

    box-shadow:0 20px 50px rgba(0,0,0,0.18);

    color:#1f2937;

    max-width:450px;

    margin:auto;
}


.login-card h3{
    font-size:25px;

    font-weight:700;

    margin-bottom:8px;
}


.login-card p{
    color:#6b7280;

    font-size:15px;

    margin-bottom:25px;
}


.panel-card{
    border:1px solid #e5e7eb;

    border-radius:14px;

    padding:20px;

    margin-bottom:15px;

    transition:0.3s;

    background:#fff;
}


.panel-card:hover{
    transform:translateY(-3px);

    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}


.panel-link{
    display:flex;

    justify-content:space-between;

    align-items:center;

    text-decoration:none;

    color:inherit;
}


.panel-icon{
    width:48px;

    height:48px;

    border-radius:12px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:#eaf4fb;

    color:#075386;

    font-size:20px;

    margin-bottom:12px;
}


.panel-card h5{
    font-size:18px;

    font-weight:700;

    margin-bottom:5px;
}


.panel-card small{
    color:#6b7280;
}


.arrow{
    color:#075386;

    font-size:18px;
}


.info-section{
    background:white;

    padding:70px 0;
}


.info-title{
    text-align:center;

    margin-bottom:45px;
}


.info-title h2{
    font-weight:750;

    color:#075386;
}


.info-title p{
    color:#6b7280;
}


.feature-card{
    background:#f8fafc;

    border:1px solid #e5e7eb;

    padding:30px;

    border-radius:16px;

    height:100%;

    text-align:center;

    transition:0.3s;
}


.feature-card:hover{
    transform:translateY(-5px);

    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}


.feature-icon{
    width:60px;

    height:60px;

    background:#eaf4fb;

    color:#075386;

    border-radius:15px;

    display:flex;

    align-items:center;

    justify-content:center;

    margin:0 auto 18px;

    font-size:24px;
}


.feature-card h5{
    font-weight:700;

    color:#075386;

    margin-bottom:12px;
}


.feature-card p{
    color:#6b7280;

    font-size:14px;

    line-height:1.7;
}


.contact-section{
    background:#f5f8fc;

    padding:75px 0;
}


.contact-title{
    text-align:center;

    margin-bottom:45px;
}


.contact-title h2{
    color:#075386;

    font-weight:750;

    margin-bottom:10px;
}


.contact-title p{
    color:#6b7280;

    font-size:16px;
}


.contact-card{
    background:white;

    border:1px solid #e5e7eb;

    border-radius:16px;

    padding:32px 25px;

    text-align:center;

    height:100%;

    transition:0.3s;
}


.contact-card:hover{
    transform:translateY(-5px);

    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}


.contact-icon{
    width:65px;

    height:65px;

    background:#eaf4fb;

    color:#075386;

    border-radius:16px;

    display:flex;

    align-items:center;

    justify-content:center;

    margin:0 auto 18px;

    font-size:25px;
}


.contact-card h5{
    color:#075386;

    font-size:19px;

    font-weight:700;

    margin-bottom:12px;
}


.contact-card p{
    color:#374151;

    margin-bottom:6px;

    font-size:15px;

    line-height:1.6;
}


.contact-card a{
    color:#075386;

    text-decoration:none;

    font-weight:600;
}


.contact-card a:hover{
    color:#e0a800;

    text-decoration:underline;
}


.contact-small{
    color:#6b7280 !important;

    font-size:13px !important;
}


footer{
    background:#063c61;

    color:white;

    text-align:center;

    padding:25px 10px;
}


footer p{
    margin:0;

    font-size:14px;

    color:rgba(255,255,255,0.8);
}


footer .copyright{
    margin-top:12px;

    font-size:13px;

    color:rgba(255,255,255,0.55);
}


@media(max-width:991px){

    .navbar-custom{
        padding:15px 4%;
    }


    .nav-link{
        margin:8px 0;
    }


    .hero{
        padding:60px 0;
    }


    .hero h1{
        font-size:40px;
    }


    .login-card{
        margin-top:30px;
    }

}


@media(max-width:576px){

    .logo-title{
        font-size:20px;
    }


    .logo-subtitle{
        font-size:9px;
    }


    .university-logo{
        width:42px;

        height:42px;
    }


    .hero h1{
        font-size:32px;
    }


    .hero-subtitle{
        font-size:18px;
    }


    .hero-description{
        font-size:15px;
    }


    .login-card{
        padding:25px 20px;
    }


    .contact-section{
        padding:55px 15px;
    }

}

</style>

</head>


<body>

<nav class="navbar navbar-expand-lg navbar-custom">

<div class="container-fluid">


<!-- UNIVERSITY LOGO + TITLE -->

<a class="logo" href="index.php">

<img
    src="assets/image/seu_logo.png"
    alt="South Eastern University Logo"
    class="university-logo"
>


<div class="logo-text">

<span class="logo-title">
FAC Election
</span>

<span class="logo-subtitle">
Student Election Management System
</span>

</div>

</a>


<button
    class="navbar-toggler bg-light"
    type="button"
    data-bs-toggle="collapse"
    data-bs-target="#navbarMenu"
    aria-controls="navbarMenu"
    aria-expanded="false"
    aria-label="Toggle navigation">

<i class="fa-solid fa-bars"></i>

</button>


<div
    class="collapse navbar-collapse"
    id="navbarMenu">


<ul class="navbar-nav ms-auto align-items-lg-center">



<li class="nav-item">

<a href="#home" class="nav-link">
Home
</a>

</li>


<li class="nav-item">

<a href="#about" class="nav-link">
About
</a>

</li>


<li class="nav-item">

<a href="#features" class="nav-link">
Features
</a>

</li>


<li class="nav-item me-lg-2">

<a href="#contact" class="nav-link">
Contact
</a>

</li>


<li class="nav-item mt-2 mt-lg-0">

<a
    href="student/index.php"
    class="student-btn">

<i class="fa-solid fa-user-graduate"></i>

Student Panel

</a>

</li>




<li class="nav-item ms-lg-2 mt-2 mt-lg-0">

<a
    href="admin/index.php"
    class="admin-btn">

<i class="fa-solid fa-user-shield"></i>

Admin Panel

</a>

</li>


</ul>

</div>

</div>

</nav>




<section
    class="hero"
    id="home">


<div class="container hero-content">


<div class="row align-items-center">



<div class="col-lg-7">


<div class="hero-text">




<div class="badge-election">

<i class="fa-solid fa-circle-check"></i>

Official Student Election Portal

</div>




<h1>

Student Union

<br>

<span>Election 2026</span>

</h1>




<div class="hero-subtitle">

Faculty of Arts and Culture

<br>

South Eastern University of Sri Lanka

</div>




<p class="hero-description">

A secure and convenient platform for students
to participate in the Student Union Election.
Make your voice heard and choose your representatives.

</p>


</div>

</div>



<div class="col-lg-5">


<div class="login-card">


<h3>
Welcome
</h3>


<p>
Choose your portal to continue.
</p>


<div class="panel-card">


<a
    href="student/index.php"
    class="panel-link">


<div>


<div class="panel-icon">

<i class="fa-solid fa-user-graduate"></i>

</div>


<h5>
Student Panel
</h5>


<small>

Login, register and participate in the election.

</small>


</div>


<div class="arrow">

<i class="fa-solid fa-chevron-right"></i>

</div>


</a>

</div>



<div class="panel-card">


<a
    href="admin/index.php"
    class="panel-link">


<div>


<div class="panel-icon">

<i class="fa-solid fa-user-shield"></i>

</div>


<h5>
Admin Panel
</h5>


<small>

Manage candidates, election and results.

</small>


</div>


<div class="arrow">

<i class="fa-solid fa-chevron-right"></i>

</div>


</a>

</div>


</div>

</div>


</div>

</div>

</section>



<section
    class="info-section"
    id="about">


<div class="container">


<div class="info-title">


<h2>
About the Election System
</h2>


<p>

A simple, secure and efficient way to conduct student elections.

</p>


</div>



<div
    class="row g-4"
    id="features">




<div class="col-md-4">

<div class="feature-card">


<div class="feature-icon">

<i class="fa-solid fa-shield-halved"></i>

</div>


<h5>
Secure Voting
</h5>


<p>

Student authentication and voting controls
help protect the election process.

</p>


</div>

</div>




<div class="col-md-4">

<div class="feature-card">


<div class="feature-icon">

<i class="fa-solid fa-bolt"></i>

</div>


<h5>
Easy to Use
</h5>


<p>

Students can register, log in and participate
through a simple and user-friendly interface.

</p>


</div>

</div>




<div class="col-md-4">

<div class="feature-card">


<div class="feature-icon">

<i class="fa-solid fa-chart-column"></i>

</div>


<h5>
Election Management
</h5>


<p>

Administrators can manage candidates,
election settings and results from one place.

</p>


</div>

</div>


</div>

</div>

</section>



<section
    class="contact-section"
    id="contact">


<div class="container">


<div class="contact-title">


<h2>
Contact Us
</h2>


<p>

For more information about the Student Union Election,
please contact the election administration.

</p>


</div>



<div class="row g-4">



<div class="col-md-4">

<div class="contact-card">


<div class="contact-icon">

<i class="fa-solid fa-building-columns"></i>

</div>


<h5>
University
</h5>


<p>

South Eastern University of Sri Lanka

</p>


<p class="contact-small">

University Park, Oluvil, Sri Lanka

</p>


</div>

</div>


<div class="col-md-4">

<div class="contact-card">


<div class="contact-icon">

<i class="fa-solid fa-envelope"></i>

</div>


<h5>
Email
</h5>


<p>

<a href="mailto:seusl@gmail.com">

seusl@gmail.com

</a>

</p>


<p class="contact-small">

Election Administration

</p>


</div>

</div>


<div class="col-md-4">

<div class="contact-card">


<div class="contact-icon">

<i class="fa-solid fa-phone"></i>

</div>


<h5>
Phone
</h5>


<p>

<a href="tel:+94672255168">

+94 67 2255168

</a>

</p>


<p class="contact-small">

Election Administration

</p>


</div>

</div>


</div>

</div>

</section>



<footer>


<p>

<i class="fa-solid fa-landmark"></i>

&nbsp;

Student Union Election Management System

</p>


<p class="mt-2">

Faculty of Arts and Culture |

South Eastern University of Sri Lanka

</p>


<p class="copyright">

&copy; 2026 FAC Election. All Rights Reserved.

</p>


</footer>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>