<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">

			<ul class="nav nav-primary">
				<li class="nav-item active">
					<a href="{{ route('dashboard') }}">
						<i class="fas fa-home"></i>
						<p>Dashboard</p>
					</a>
				</li>

				<li class="nav-item active">
					<a href="{{ route('bandwidth.queue') }}">
						<i class="fas fa-rocket"></i>
						<p>Bandwidth</p>
					</a>
				</li>

				<li class="nav-item active">
					<a data-toggle="collapse" href="#base">
						<i class="fas fa-rocket"></i>
						<p>PPPoE</p>
						<span class="caret"></span>
					</a>
					<div class="collapse" id="base">
						<ul class="nav nav-collapse">
							<li>
								<a href="{{ route('pppoe.secret') }}">
									<span class="sub-item">PPPoE Secret</span>
								</a>
							</li>
						</ul>
					</div>
				</li>

				<li class="nav-item active">
					<a data-toggle="collapse" href="#base2">
						<i class="fas fa-signal"></i>
						<p>Hotspot</p>
						<span class="caret"></span>
					</a>
					<div class="collapse" id="base2">
						<ul class="nav nav-collapse">
							<li>
								<a href="{{ route('hotspot.user') }}">
									<span class="sub-item">Hotspot User</span>
								</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- End Sidebar -->