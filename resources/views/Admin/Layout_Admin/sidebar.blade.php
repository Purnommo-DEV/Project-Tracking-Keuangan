<div class="sidebar sidebar-style-2" data-background-color="white">
			
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="info">
                      <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
									Admin
									<span class="user-level">Administrator</span>
                                <span class="caret"></span>
                                </span>
                            </a>
                </div>
            </div>

            <ul class="nav nav-primary">
                <li class="nav-item {{request()->routeIs('DaftarKegiatan*') ? 'active' : ''}}">
					<a href="{{ route('DaftarKegiatan') }}">
						<i class="fas fa-clipboard-list"></i>
						<p>Kegiatan</p>
					</a>
				</li>
                <li class="nav-item {{request()->routeIs('LogOut*') ? 'active' : ''}}">
					<a href="{{ route('LogOut') }}">
						<i class="fas fa-sign-out-alt"></i>
						<p>Log Out</p>
					</a>
				</li>
            </ul>
        </div>
    </div>
</div>