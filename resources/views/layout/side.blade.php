<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-item">
                            <a href="{{ route('dashboard') }}" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        {{-- Menu untuk Guru --}}
                        @if (Auth::user()->role == 'guru')
                        <li class="sidebar-title">Guru</li>
                        <li class="sidebar-item">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-file-text"></i>
                                <span>Kelola Pretest</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('kelolamateri') }}" class='sidebar-link'>
                                <i class="bi bi-book-half"></i>
                                <span>Kelola Materi</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-file-text-fill"></i>
                                <span>Kelola Postest</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-award"></i>
                                <span>Leaderboard</span>
                            </a>
                        </li>
                        @endif

                        {{-- Menu untuk Siswa --}}
                        @if (Auth::user()->role == 'siswa')
                        <li class="sidebar-title">Siswa</li>
                        <li class="sidebar-item  ">
                            <a href="form-layout.html" class='sidebar-link'>
                                <i class="bi-file-text"></i>
                                <span>Pretest</span>
                            </a>
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-book-half"></i>
                                <span>Courses</span>
                            </a>
                            <ul class="submenu ">
                                <!-- Looping Course -->
                                @foreach ($courses as $course)
                                <li class="submenu-item ">
                                    <a href="{{ route('course', $course->id) }}">{{ $course->course }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="sidebar-item  ">
                            <a href="form-layout.html" class='sidebar-link'>
                                <i class="bi-file-text-fill"></i>
                                <span>Postest</span>
                            </a>
                        </li>
                        <li class="sidebar-item  ">
                            <a href="form-layout.html" class='sidebar-link'>
                                <i class="bi bi-award"></i>
                                <span>Leaderboard</span>
                            </a>
                        </li>
                        @endif

                        {{-- Menu untuk Admin --}}
                        @if (Auth::user()->role == 'admin')
                        <li class="sidebar-title">Admin</li>
                        <li class="sidebar-item  ">
                            <a href="{{ route('kelolaakun') }}" class='sidebar-link'>
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Kelola Akun</span>
                            </a>
                        </li>
                        <li class="sidebar-item  ">
                            <a href="{{ route('kelolacourses') }}" class='sidebar-link'>
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Kelola Courses</span>
                            </a>
                        </li>
                        @endif

                        <li class="sidebar-title">Settings</li>
                        <li class="sidebar-item">
                            <a href="{{ route('logout') }}" class='sidebar-link'>
                                <i class="bi bi-arrow-bar-left"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>