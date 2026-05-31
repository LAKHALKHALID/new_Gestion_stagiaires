<div class="main-header" data-background-color="blue">
			<div class="logo-header">
				<a href="" class="text-white text-decoration-none logo fw-semibold fs-4 d-flex align-items-center gap-2">
					{{-- <img style="width: 40px" src="../assets/img/logooo.png" alt="navbar brand" class="navbar-brand"> --}}
					OFPPT

				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="fa fa-bars"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>
				<div class="navbar-minimize">
					<button class="btn btn-minimize btn-rounded">
						<i class="fa fa-bars"></i>
					</button>
				</div>
			</div>
			<nav class="navbar navbar-header navbar-expand-lg">
				<div class="container-fluid">
					<div class="navbar-nav ms-2">
						<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
							<form action="{{route('update.annee')}}" method="post" class="d-flex mb-0" role="search">
								@csrf
								<select name="nom_annee_scolaire"  id="" class="form-select form-select-md shadow-none border-secondary-subtle" aria-label="Selection options">
									@foreach ($annees as $annee)
											<option value="{{$annee}}" {{ session('selected_annee') == $annee ? 'selected' : '' }}>
												{{$annee}}
											</option>
									@endforeach
								</select>
								<button class="btn btn-outline-light ms-3" type="submit">Search</button>
							</form>
						</div>
					</div>
				    <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            {{ __('Profile') }}
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            {{ __('Log Out') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
				</div>
			</nav>
		</div>