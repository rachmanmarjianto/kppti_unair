<!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="./index.html">
                                <img src="{{ asset('src/assets/img/logo.svg') }}" class="navbar-logo" alt="logo">
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="./index.html" class="nav-link"> CORK </a>
                        </div>
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                        </div>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">

                    <li class="menu @if($menu == 'home') active @endif">
                        <a href="{{ route('admin.home') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                                <span>Home</span>
                            </div>
                        </a>
                    </li>
                                     

                    <li class="menu @if($menu == 'acara') active @endif">
                        <a href="{{ route('admin.acara') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <span>Acara</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu @if($menu == 'jadwal-penting') active @endif">
                        <a href="{{ route('admin.jadwal-penting') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <span>Jadwal Penting</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu @if($menu == 'users') active @endif">
                        <a href="#users" data-bs-toggle="collapse" aria-expanded="@if($menu == 'users') true @else false @endif" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <span>Users</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled @if($menu == 'users') show @endif" id="users" data-bs-parent="#accordionExample">
                            <li @if($submenu == 'admin') class="active" @endif>
                                <a href="{{ route('admin.admin-users') }}"> Admin / SC / Petugas Kit </a>
                            </li>
                            <li @if($submenu == 'peserta') class="active" @endif>
                                <a href="{{ route('admin.peserta') }}"> Peserta </a>
                            </li>
                            <li @if($submenu == 'acara-peserta') class="active" @endif>
                                <a href="{{ route('admin.peserta.acara') }}"> Acara </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu @if($menu == 'narasumber') active @endif">
                        <a href="#narasumber" data-bs-toggle="collapse" aria-expanded="@if($menu == 'narasumber') true @else false @endif" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mic"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>
                                <span>Narasumber</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled @if($menu == 'narasumber') show @endif" id="narasumber" data-bs-parent="#accordionExample">
                            <li @if($submenu == 'ajuan') class="active" @endif>
                                <a href="{{ route('admin.narasumber') }}"> Ajuan </a>
                            </li>
                            <li @if($submenu == 'reviewer') class="active" @endif>
                                <a href="{{ route('admin.narasumber.reviewer') }}"> Set Reviewer </a>
                            </li>
                            <li @if($submenu == 'poster') class="active" @endif>
                                <a href="{{ route('admin.narasumber.poster') }}"> Poster </a>
                            </li>
                            <li @if($submenu == 'terpilih') class="active" @endif>
                                <a href="{{ route('admin.narasumber.terpilih') }}"> File Presentasi </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu @if($menu == 'pameran') active @endif">
                        <a href="#pameran" data-bs-toggle="collapse" aria-expanded="@if($menu == 'pameran') true @else false @endif" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                <span>Pameran</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled @if($menu == 'pameran') show @endif" id="pameran" data-bs-parent="#accordionExample">
                            <li @if($submenu == 'ajuan') class="active" @endif>
                                <a href="{{ route('admin.pameran.ajuan') }}"> Ajuan </a>
                            </li>
                            <li @if($submenu == 'tagihan-pameran') class="active" @endif>
                                <a href="{{ route('admin.tagihan-pameran') }}"> Tagihan Pameran </a>
                            </li>
                            <li @if($submenu == 'nomor-stand') class="active" @endif>
                                <a href="{{ route('admin.pameran.nomor-stand') }}"> Nomor Stand </a>
                            </li>
                            <li @if($submenu == 'reviewer') class="active" @endif>
                                <a href="{{ route('admin.pameran.reviewer') }}"> Reviewer SC </a>
                            </li>
                            <li @if($submenu == 'terpilih') class="active" @endif>
                                <a href="{{ route('admin.pameran.terpilih') }}"> Terpilih </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu @if($menu == 'data-master') active @endif">
                        <a href="#data-master" data-bs-toggle="collapse" aria-expanded="@if($menu == 'data-master') true @else false @endif" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                                <span>Data Master</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled @if($menu == 'data-master') show @endif" id="data-master" data-bs-parent="#accordionExample">
                            <li @if($submenu == 'universitas') class="active" @endif>
                                <a href="{{ route('admin.data-master.universitas') }}"> Universitas </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu @if($menu == 'seminar-kit') active @endif">
                        <a href="#seminar-kit" data-bs-toggle="collapse" aria-expanded="@if($menu == 'seminar-kit') true @else false @endif" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                <span>Seminar Kit</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled @if($menu == 'seminar-kit') show @endif" id="seminar-kit" data-bs-parent="#accordionExample">
                            <li @if($submenu == 'master-kit') class="active" @endif>
                                <a href="{{ route('admin.seminar-kit.master') }}"> Master Kit </a>
                            </li>
                            <li @if($submenu == 'progress') class="active" @endif>
                                <a href="{{ route('admin.seminar-kit.progress') }}"> Progress </a>
                            </li>
                        </ul>
                    </li>

                </ul>
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->