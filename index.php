<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Navbar</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* Custom CSS */
    body {
      background-color: #f8f9fa;
      padding-top: 60px; /* Adjusted padding to account for navbar */
    }

    .navbar {
      background-color: #343a40;
    }

    .navbar-nav .nav-link {
      color: #ffffff;
      font-weight: bold;
    }

    .navbar-nav .nav-link:hover {
      color: #ffc107;
    }

    /* Center the navbar content */
    .navbar-nav {
      margin: auto;
      display: flex;
      justify-content: space-between;
    }

    .navbar-nav .nav-item {
      margin-right: 20px;
    }

    .jumbotron {
      background-color: #343a40;
      color: #ffffff;
      padding: 20px 0;
      margin-bottom: 0;
    }

    .carousel-item img {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }

    /* Custom style for specific carousel item */
    .custom-carousel-item img {
      height: auto;
    }

    .container {
      margin-top: 30px;
    }

    .card {
      margin-bottom: 30px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Govt Schemes Eligibility</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Hospital Facilities</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Login
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="patient-login.php">Patient</a>
          <a class="dropdown-item" href="doctor-login.php">Doctor</a>
          <a class="dropdown-item" href="medical_worker_login.php">Medical Worker</a>
        </div>
      </li>
    </ul>
  </div>
</nav>

<div class="jumbotron text-center">
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="modiji.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="sonu.avif" class="d-block w-100 custom-carousel-item" alt="...">
      </div>
      <div class="carousel-item">
        <img src="images.png" class="d-block w-100" alt="...">
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <h1>Welcome to Our Website</h1>
  <p>A place where you can find information about healthcare services.</p>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Donation</h5>
          <p class="card-text">Description of service 1.</p>
          <a href="#" class="btn btn-primary">Learn More</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Types of Diseases</h5>
          <p class="card-text">Description of service 2.</p>
          <a href="#" class="btn btn-primary">Learn More</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Precautions</h5>
          <p class="card-text">Description of service 3.</p>
          <a href="#" class="btn btn-primary">Learn More</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
