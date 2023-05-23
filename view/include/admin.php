<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="index.php?action=admin" class="text-nowrap logo-img">
                    <img src="./assets/img/heading/logo/dgw-logo-grey.png" alt="" style="width:80%;" />
                </a>
                <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                    <i class="ti ti-x fs-8"></i>
                </div>
            </div>
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link  " href="index.php?action=admin&function=dashboard" aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Management</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="index.php?action=admin&function=product" aria-expanded="false">
                            <span>
                                <i class="ti ti-box"></i>
                            </span>
                            <span class="hide-menu">Product </span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="index.php?action=admin&function=member" aria-expanded="false">
                            <span>
                                <i class="fa-solid fa-people-group"></i>
                            </span>
                            <span class="hide-menu">MEMBER</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="index.php?action=admin&function=category" aria-expanded="false">
                            <span>
                                <i class="ti ti-category"></i>
                            </span>
                            <span class="hide-menu">Category</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="index.php?action=admin&function=news" aria-expanded="false">
                            <span>
                                <i class="fa-solid fa-newspaper fa-bounce"></i>
                            </span>
                            <span class="hide-menu">NEWS</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="./ui-typography.html" aria-expanded="false">
                            <span>
                                <i class="ti ti-typography"></i>
                            </span>
                            <span class="hide-menu">Typography</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">PAGE</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" target="_blank" href="index.php?action=home" aria-expanded="false">
                            <span>
                                <i class="fa-solid fa-house"></i>
                            </span>
                            <span class="hide-menu">HOME</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" target="_blank" href="index.php?action=shop" aria-expanded="false">
                            <span>
                                <i class="fa-solid fa-shop fa-beat"></i>
                            </span>
                            <span class="hide-menu">SHOP</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" target="_blank" href="index.php?action=libary" aria-expanded="false">
                            <span>
                                <i class="fa-solid fa-book"></i>
                            </span>
                            <span class="hide-menu">LIBARY</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" target="_blank" href="index.php?action=cart" aria-expanded="false">
                            <span>
                                <i class="fa-solid fa-cart-shopping"></i>
                            </span>
                            <span class="hide-menu">CART</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" target="_blank" href="index.php?action=user" aria-expanded="false">
                            <span>
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <span class="hide-menu">USER</span>
                        </a>
                    </li>
                    <!-- <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">AUTHOR</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="./icon-tabler.html" aria-expanded="false">
                            <span>
                                <i class="ti ti-mood-happy"></i>
                            </span>
                            <span class="hide-menu">AUTHOR</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
                            <span>
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </span>
                            <span class="hide-menu">LOG OUT</span>
                        </a>
                    </li> -->
                </ul>

            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
        <!--  Header Start -->
        <header class="app-header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item d-block d-xl-none">
                        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                            <i class="ti ti-bell-ringing"></i>
                            <div class="notification bg-primary rounded-circle"></div>
                        </a>
                    </li>
                </ul>
                <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-user fs-6"></i>
                                        <p class="mb-0 fs-3">My Profile</p>
                                    </a>
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-mail fs-6"></i>
                                        <p class="mb-0 fs-3">My Account</p>
                                    </a>
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-list-check fs-6"></i>
                                        <p class="mb-0 fs-3">My Task</p>
                                    </a>
                                    <button onclick="logout()" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!--  Header End -->
        <div id="body" class="container-fluid">

        </div>
    </div>
</div>
<script>
    function logout() {
        Swal.fire({
            title: "Do you want to logout?",

            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Log out!",
        }).then((result) => {
            if (result.isConfirmed) {
                document.cookie =
                    "c_user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                Swal.fire({
                    icon: "success",
                    title: "Your account has been logged out",
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    window.location.replace("index.php");
                });
            }
        });
    }
</script>
<script src="./assets/js/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="./assets/js/sidebarmenu.js"></script>
<script src="./assets/js/app.min.js"></script>