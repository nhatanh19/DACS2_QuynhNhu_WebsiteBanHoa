 <!-- Bootstrap CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <!-- Font Awesome -->
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

 <header>
     <style>
         /* Custom styles for navbar */

         .navbar-brand img {
             width: 50px;
             height: auto;
         }

         .nav-link {
             color: #333;
             font-weight: 500;
         }

         .nav-link:hover {
             color: #ff69b4;
         }

         /* Search bar styling */

         .search-form {
             position: relative;
         }

         .search-form input {
             padding-right: 40px;
         }

         .search-form button {
             position: absolute;
             right: 0;
             top: 0;
             border: none;
             background: none;
             padding: 8px 12px;
         }
     </style>
     <!-- Navbar -->
     <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
         <div class="container">
             <a class="navbar-brand" href="#">
                 <img src="img/logo-home.jpg" alt="Logo">
             </a>
             <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                 <span class="navbar-toggler-icon"></span>
             </button>

             <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                     <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                             Bộ sưu tập
                         </a>
                         <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="#">Hoa sinh nhật</a></li>
                             <li><a class="dropdown-item" href="#">Hoa cưới</a></li>
                             <li><a class="dropdown-item" href="#">Hoa kỷ niệm</a></li>
                         </ul>
                     </li>
                     <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                             Loại hoa
                         </a>
                         <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="#">Hoa hồng</a></li>
                             <li><a class="dropdown-item" href="#">Hoa hướng dương</a></li>
                             <li><a class="dropdown-item" href="#">Hoa cẩm chướng</a></li>
                             <li><a class="dropdown-item" href="#">Hoa tulip</a></li>
                         </ul>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link text-danger" href="./cartegory.php">Flash Sale</a>
                     </li>
                 </ul>

                 <!-- Search form -->
                 <form class="search-form d-flex me-3">
                     <input class="form-control" type="search" placeholder="Tìm kiếm">
                     <button type="submit">
                         <i class="fas fa-search"></i>
                     </button>
                 </form>

                 <!-- Icons -->
                 <div class="d-flex align-items-center">
                     <a href="#" class="nav-link px-3">
                         <i class="fas fa-user"></i>
                     </a>
                     <a href="#" class="nav-link px-3">
                         <i class="fas fa-shopping-cart"></i>
                     </a>
                 </div>
             </div>
         </div>
     </nav>
 </header>