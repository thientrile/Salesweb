<div id="header">
	<nav id="nav-menu" class="navbar navbar-expand-sm navbar-dark fixed-top">
		<div class="container-fluid d-sm-flex justify-content-around">
			<a class="navbar-brand" href="index.php?action=home"><img src="./assets/img/heading/logo/dgw-logo-grey.png" alt="" /></a>

			<div class="offcanvas offcanvas-end text-bg-white" id="right">
				<div class="offcanvas-header">
					<div class="offcanvas-title">
						
					</div>
					<button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
				</div>
				<div class="offcanvas-body">
					<div class="collapse navbar-collapse show" id="mynavbar">
						<ul class="navbar-nav me-auto">
							<li class="nav-item">
								<a class="nav-link" href="index.php?action=home">
									HOME
								</a>


							</li>
							<li class="nav-item ">
								<a class="nav-link" href="index.php?action=shop">
									SHOP
								</a>

							</li>

							<li class="nav-item">
								<a class="nav-link" href="index.php?action=library">Library</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="javascript:void(0)"> ABOUT </a>
							</li>
							<li class="nav-item ">
								<a class="nav-link" href="index.php?action=blog">
									Blog
								</a>

							</li>
							<li class="nav-item">
								<a class="nav-link" href="javascript:void(0)">Contact</a>
							</li>

						</ul>
					</div>
				</div>

			</div>
			<div class="d-flex">
				<a href="index.php?action=user" id="user-login" class="heading-icon me-4"><i class="fa-solid fa-user"></i></a>
				<a href="index.php?action=cart" class="heading-icon me-4"><i class="fa-solid fa-cart-shopping"></i>
					<span id="countCart">0</span>
				</a>
				<button style="background: transparent; border: none" class="heading-icon me-4" onclick="typeSearch()" data-bs-toggle="modal" data-bs-target="#Modal-search">
					<i class="fa-solid fa-magnifying-glass"></i>
				</button>
				<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#right">
					<i class="fa-solid fa-bars"></i>
				</button>
			</div>
		</div>
	</nav>
</div>

<div class="modal fade" id="Modal-search">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<!-- Modal body -->
			<div class="modal-body" style="border: none">
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				<div class="container p-5">
					<h1>Search</h1>
					<form action="" method="get">
						<div class="row">
							<div class="col-3" style="padding: 0;">
								<select name="action" class="w-100 form-select input-group-text" id="select-search">
									<option value="shop">Product</option>
									<option value="docs">Docs</option>
									<option value="blog">Blog</option>
								</select>
							</div>
							<div class="col-9" style="padding: 0;">
								<input class="form-control w-100" name="keySearch" type="text" placeholder="Start typing and press Enter to search" value="<?php echo isset($_GET['keySearch']) ? $_GET['keySearch'] : "" ?>" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/nav-menu.js"></script>