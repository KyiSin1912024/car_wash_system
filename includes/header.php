        <!-- Top Bar Start -->
        <div class="top-bar">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-4 col-md-12">
                        <div class="logo">
                            <a href="../user/index.php" class="text-decoration-none">
                                <h3>Vehicle Washing <span style="color: #E81C2E;">Management System</span></h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">

                        <div class="dropdown">
                            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="icon fa fa-user pe-1"></i><?php if(!isset($user)) { ?> My Account <?php } else  echo $user['name'] ?></a>
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <?php if(!isset($user)) { ?>
                                <li><a class="dropdown-item border-bottom shadow-sm py-2" href="../auth/login.php">Login</a></li>
                                <li><a class="dropdown-item" href="../auth/signup.php"> New customer? <span class="text-primary">Sign up</span></a></li>
                                <?php } else { ?>
                                    <li><a class="dropdown-item border-bottom shadow-sm pb-3" href="#">My Profile</a></li>
                                <li>
                                    <a class="dropdown-item py-2 btn" name="logout" href="../auth/logout.php?logout=logout">Logout</a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Top Bar End -->

        <!-- Nav Bar Start -->
        <div class="nav-bar">
            <div class="container">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
                    <a href="#" class="navbar-brand">MENU</a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
                            <a href="#about" class="nav-item nav-link">About</a>
                            <a href="#washing-plans" class="nav-item nav-link">Washing Plans</a>
                            <a href="#price" class="nav-item nav-link">Prices</a>
                            <a href="#contact" class="nav-item nav-link">Contact</a>
                        </div>
                        <div class="ml-auto">
                            <a class="btn btn-custom" href="#booking">Get Appointment</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Nav Bar End -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>