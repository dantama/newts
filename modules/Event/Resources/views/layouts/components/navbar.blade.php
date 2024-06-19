 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"> <i class="fa fa-bars"></i> </button> 
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."> 
            <div class="input-group-append"> <button class="btn btn-danger" type="button"> <i class="fas fa-search fa-sm"></i> </button> </div>
        </div>
    </form>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="javascript:;" id="searchDropdown" role="button" data-toggle="dropdown"> <i class="fas fa-search fa-fw"></i> </a> 
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."> 
                        <div class="input-group-append"> <button class="btn btn-danger" type="button"> <i class="fas fa-search fa-sm"></i> </button> </div>
                    </div>
                </form>
            </div>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="javascript:;" id="alertsDropdown" role="button" data-toggle="dropdown"> <i class="fas fa-bell fa-fw"></i> <!--span class="badge badge-danger badge-counter">3+</span--> </a> 
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <h6 class="dropdown-header bg-danger border-0"> Notifikasi </h6>
                <!--a class="dropdown-item d-flex align-items-center" href="javascript:;">
                    <div class="mr-3">
                        <div class="icon-circle bg-danger"> <i class="fas fa-file-alt text-white"></i> </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 12, 2019</div>
                        <span class="font-weight-bold">A new monthly report is ready to download!</span> 
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="javascript:;">
                    <div class="mr-3">
                        <div class="icon-circle bg-success"> <i class="fas fa-donate text-white"></i> </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 7, 2019</div>
                        $290.29 has been deposited into your account! 
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="javascript:;">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning"> <i class="fas fa-exclamation-triangle text-white"></i> </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">December 2, 2019</div>
                        Spending Alert: We've noticed unusually high spending for your account. 
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="javascript:;">Show All Alerts</a--> 
                <a class="dropdown-item text-center text-gray-500 disabled py-3" href="javascript:;">Tidak ada notif</a> 
            </div>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="javascript:;" id="messagesDropdown" role="button" data-toggle="dropdown"> <i class="fas fa-envelope fa-fw"></i> <!--span class="badge badge-danger badge-counter">7</span--> </a> 
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <h6 class="dropdown-header bg-danger border-0"> Pesan </h6>
                <!--a class="dropdown-item d-flex align-items-center" href="javascript:;">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{ asset('img/default-avatar.svg') }}" alt=""> 
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="javascript:;">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{ asset('img/default-avatar.svg') }}" alt=""> 
                        <div class="status-indicator"></div>
                    </div>
                    <div>
                        <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                        <div class="small text-gray-500">Jae Chun · 1d</div>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="javascript:;">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{ asset('img/default-avatar.svg') }}" alt=""> 
                        <div class="status-indicator bg-warning"></div>
                    </div>
                    <div>
                        <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="javascript:;">
                    <div class="dropdown-list-image mr-3">
                        <img class="rounded-circle" src="{{ asset('img/default-avatar.svg') }}" alt=""> 
                        <div class="status-indicator bg-success"></div>
                    </div>
                    <div>
                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="javascript:;">Read More Messages</a--> 
                <a class="dropdown-item text-center text-gray-500 disabled py-3" href="javascript:;">Tidak ada pesan</a> 
            </div>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="javascript:;" id="userDropdown" role="button" data-toggle="dropdown"> <span class="mr-2 d-none d-lg-inline text-dark small">{{ auth()->user()->profile->name }}</span> <img class="img-profile rounded-circle" src="{{ auth()->user()->profile->avatar_path }}"> </a> 
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <h6 class="dropdown-header"> Akun saya </h6>
                <a class="dropdown-item py-2 text-muted" href="{{ route('account::index') }}"> <i class="fas fa-user fa-sm fa-fw mr-2"></i> Profil </a> 
                <a class="dropdown-item py-2 text-muted" href="{{ route('account::password', ['next' => url()->previous()]) }}"> <i class="fas fa-lock fa-sm fa-fw mr-2"></i> Ubah sandi </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item py-2 text-muted" href="{{ route('account::auth.logout') }}" onclick="event.preventDefault(); $('#logout-form').submit();"> <i class="fas fa-power-off fa-sm fa-fw mr-2"></i> Logout </a> 
            </div>
        </li>
    </ul>
</nav>