<!DOCTYPE HTML>
<!--
	ZeroFour by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Sekolah</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="{{asset('/css/main.css')}}" />
		<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"/>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" defer></script>
	</head>
	<body class="homepage is-preload">
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header-wrapper">
					<div class="container">

						<!-- Header -->
							<header id="header">
								<div class="inner">

									<!-- Logo -->
										<h1><a href="{{ route('home') }}" id="logo">Sekolah</a></h1>

									<!-- Nav -->
										<nav id="nav">
											<ul>
												
												<!-- Button trigger modal -->
												<li>
													@if (Auth::check() == true)
													<a href="{{route('dashboard')}}">Dashboard</a>
													@else
													<a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
														Login
													</a>
													@endif
												</li>
												
											</ul>
										</nav>
								</div>
							</header>

						<!-- Banner -->
							<div id="banner">
								<h2>Sekolah</h2>
							</div>

					</div>
				</div>

			<!-- Main Wrapper -->
				<div id="main-wrapper">
					<div class="wrapper style1">
						<div class="inner">

							<!-- Feature 1 -->
								<section class="container box feature1">
									<div class="row">
										<div class="col-12">
											<header class="first major">
												<h2>Sebuah Website Untuk Informasi Sekolah</h2>
												<p>Memuat Informasi-informasi tentang sekolah seperti guru, siswa, serta jadwal sekolah</p>
											</header>
										</div>
										<div class="col-4 col-12-medium">
											<section>
												<img src="{{asset('/images/pic01.jpg')}}" alt="" />
												<header class="second icon solid fa-user">
													<h3>Here's a Heading</h3>
													<p>And a subtitle</p>
												</header>
											</section>
										</div>
										<div class="col-4 col-12-medium">
											<section>
												<img src="{{asset('/images/pic02.jpg')}}" alt="" />
												<header class="second icon solid fa-cog">
													<h3>Also a Heading</h3>
													<p>And another subtitle</p>
												</header>
											</section>
										</div>
										<div class="col-4 col-12-medium">
											<section>
												<img src="{{asset('/images/pic03.jpg')}}" alt="" />
												<header class="second icon solid fa-chart-bar">
													<h3>Another Heading</h3>
													<p>And yes, a subtitle</p>
												</header>
											</section>
										</div>
										<div class="col-12">
											<p>Phasellus quam turpis, feugiat sit amet ornare in, hendrerit in lectus. Praesent semper
											bibendum ipsum, et tristique augue fringilla eu. Vivamus id risus vel dolor auctor euismod
											quis eget mi. Etiam eu ante risus. Aliquam erat volutpat. Aliquam luctus mattis lectus sit
											amet pulvinar. Nam nec turpis.</p>
										</div>
									</div>
								</section>

						</div>
					</div>
					<div class="wrapper style2">
						<div class="inner">

							<!-- Feature 2 -->
								<section class="container box feature2">
									<div class="row">
										<div class="col-6 col-12-medium">
											<section>
												<header class="major">
													<h2>And this is a subheading</h2>
													<p>It’s important but clearly not *that* important</p>
												</header>
												<p>Phasellus quam turpis, feugiat sit amet ornare in, hendrerit in lectus.
												Praesent semper mod quis eget mi. Etiam eu ante risus. Aliquam erat volutpat.
												Aliquam luctus et mattis lectus sit amet pulvinar. Nam turpis nisi
												consequat etiam.</p>
												<footer>
													<a href="#" class="button medium icon solid fa-arrow-circle-right">Let's do this</a>
												</footer>
											</section>
										</div>
										<div class="col-6 col-12-medium">
											<section>
												<header class="major">
													<h2>This is also a subheading</h2>
													<p>And is as unimportant as the other one</p>
												</header>
												<p>Phasellus quam turpis, feugiat sit amet ornare in, hendrerit in lectus.
												Praesent semper mod quis eget mi. Etiam eu ante risus. Aliquam erat volutpat.
												Aliquam luctus et mattis lectus sit amet pulvinar. Nam turpis nisi
												consequat etiam.</p>
												<footer>
													<a href="#" class="button medium alt icon solid fa-info-circle">Wait, what?</a>
												</footer>
											</section>
										</div>
									</div>
								</section>

							</div>
					</div>
				</div>
		</div>

		<!-- Scripts -->
			<script src="{{asset('/js/jquery.min.js')}}"></script>
			<script src="{{asset('/js/jquery.dropotron.min.js')}}"></script>
			<script src="{{asset('/js/browser.min.js')}}"></script>
			<script src="{{asset('/js/breakpoints.min.js')}}"></script>
			<script src="{{asset('/js/util.js')}}"></script>
			<script src="{{asset('/js/main.js')}}"></script>
	</body>

	<!-- Modal -->
	<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title text-dark font-weight-bold" style="color:#212529 !important;"
						id="loginModalCenterTitle">
						Masuk Sekarang</h2>
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div>
							<div>
								<form method="POST" action="{{ route('login') }}">
									@csrf
									<div class="form-group">
										<label class="text-center label-font" for="
											exampleFormControlInput1">
											Username</label>
										<input type="text" class="form-control"
											name="username" autocomplete="off" id="username"
											placeholder="Masukan username mu disini ..">
									</div>
									<div class="form-group">
										<label class="text-center label-font" for="
											exampleFormControlInput1">
											Password</label>
										<input type="password" name="password" class="form-control" id="password"
											placeholder="Masukan password mu disini ..">
									</div>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
	
										<label class="form-check-label" for="remember">
											{{ __('Ingat Saya') }}
										</label>
									</div>
									<button class="btn btn-secondary font-weight-bold"
										style="font-size:18px;">Login
										Sekarang!</button>
									</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</html>