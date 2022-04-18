<div class="sticky-top mx-4 my-3">
    <nav class="py-2 px-3">
        <div class="row no-gutters align-items-center">
            <button class="btn btn-light btn-menu" 
                type="button" 
                id="btn-menu" 
                data-toggle="tooltip" 
                data-placement="top" 
                title="Hide sidebar">
                <i data-feather="menu"></i>
            </button>
        </div>

        <div class="nav-icons">
            <!-- alerts center -->
            <div class="btn-group mr-2">
                <button class="btn btn-light btn-dropdown" 
                data-toggle="dropdown"
                title="Alerts">
                    <span><i data-feather="bell"></i></span>
                    <span class="badge badge-danger badge-pill badge-position">2</span>
                </button>

                <div class="dropdown-menu dropdown-menu-right mt-2 py-2">
                    <div class="up-arrow"></div>
                    <div class="dropdown-item-text d-flex align-items-center px-3 py-2">
                        {{-- <span class="mr-2"><i data-feather="bell"></i></span> --}}
                        <span class="font-size-sm font-weight-600">ALERTS CENTER</span>
                    </div>
                    
                    <div class="dropdown-divider"></div>
                    
                    <button class="dropdown-item d-flex align-items-center px-3 py-2" type="button">
                        <span class="dropdown-image rounded-circle mr-2">
                            <img class="rounded-circle" 
                                alt="avatar"
                                src="https://ui-avatars.com/api/?background=dc3545&color=fff&name=Shaina&format=svg&rounded=true&bold=true&font-size=0.4&length=1">
                        </span>

                        <span class="dropdown-info">
                            <span class="subtitle font-weight-bold">Shaina</span>
                            <span class="description font-weight-600 text-truncate" style="width: 220px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, perferendis.</span>
                            <span class="description text-muted">Just now</span>
                        </span>
                    </button>
                    <button class="dropdown-item d-flex align-items-center px-3 py-2" type="button">
                        <span class="dropdown-image rounded-circle mr-2">
                            <img class="rounded-circle" 
                                alt="avatar"
                                src="https://ui-avatars.com/api/?background=3f51b5&color=fff&name=JV&format=svg&rounded=true&bold=true&font-size=0.4&length=1">
                        </span>

                        <span class="dropdown-info">
                            <span class="subtitle font-weight-bold">Jan Vincent</span>
                            <span class="description font-weight-600 text-truncate" style="width: 220px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, perferendis.</span>
                            <span class="description text-muted">Just now</span>
                        </span>
                    </button>

                    <div class="dropdown-divider"></div>

                    <button class="dropdown-item py-2 bg-light text-center" type="button">
                        <span>View All Alerts</span>
                    </button>
                </div>
            </div>

            <!-- message center -->
            <div class="btn-group mr-4">
                <button class="btn btn-light btn-dropdown" 
                    data-toggle="dropdown"
                    title="Messages">
                    <span><i data-feather="message-circle"></i></span>
                    <span class="badge badge-danger badge-pill badge-position">2</span>
                </button>

                <div class="dropdown-menu dropdown-menu-right mt-2 py-2">
                    <div class="up-arrow"></div>
                    <div class="dropdown-item-text d-flex align-items-center px-3 py-2">
                        {{-- <span class="mr-2"><i data-feather="message-circle"></i></span> --}}
                        <span class="font-size-sm font-weight-600">MESSAGES CENTER</span>
                    </div>

                    <div class="dropdown-divider"></div>

                    <button class="dropdown-item d-flex align-items-center px-3 py-2" type="button">
                        <span class="dropdown-image rounded-circle mr-2">
                            <img class="rounded-circle" 
                                alt="avatar"
                                src="https://ui-avatars.com/api/?background=3f51b5&color=fff&name=Jan&format=svg&rounded=true&bold=true&font-size=0.4&length=1">
                        </span>
                        <span class="dropdown-info">
                            <span class="subtitle font-weight-bold">Jan Vincent</span>
                            <span class="description font-weight-600 text-truncate" style="width: 220px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, perferendis.</span>
                            <span class="description text-muted">Just now</span>
                        </span>
                    </button>
                    <button class="dropdown-item d-flex align-items-center px-3 py-2" type="button">
                        <span class="dropdown-image rounded-circle mr-2">
                            <img class="rounded-circle" 
                                alt="avatar"
                                src="https://ui-avatars.com/api/?background=dc3545&color=fff&name=Shaine&format=svg&rounded=true&bold=true&font-size=0.4&length=1">
                        </span>

                        <span class="dropdown-info">
                            <span class="subtitle font-weight-bold">Jan Vincent</span>
                            <span class="description font-weight-600 text-truncate" style="width: 220px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, perferendis.</span>
                            <span class="description text-muted">Just now</span>
                        </span>
                    </button>

                    <div class="dropdown-divider"></div>

                    <button class="dropdown-item py-2 bg-light text-center" type="button">
                        <span>View All Messages</span>
                    </button>
                </div>
            </div>

            <!-- user settings -->
            <div class="btn-group">
                @php
                $user = Auth::user()->first_name. ' '.Auth::user()->last_name;
                @endphp
                
                <button class="btn btn-light btn-dropdown overflow-hidden" data-toggle="dropdown">
                    <img src="{{ (is_null(Auth::user()->profile_image))
                        ? "https://ui-avatars.com/api/?background=0061f2&color=fff&name=".Auth::user()->first_name."&format=svg&rounded=true&bold=true&font-size=0.4&length=1"
                        : asset('uploads/user_accounts/'.Auth::user()->profile_image) }}"
                    alt="{{ Auth::user()->first_name }}"
                    width="42"
                    height="55">
                </button>

                <div class="dropdown-menu dropdown-menu-right mt-2 py-2">
                    <div class="up-arrow"></div>

                    <div class="dropdown-item-text">
                        <span class="dropdown-image mr-2 overflow-hidden">
                            <img src="{{ (is_null(Auth::user()->profile_image))
                                    ? "https://ui-avatars.com/api/?background=0061f2&color=fff&name=".Auth::user()->first_name."&format=svg&rounded=true&bold=true&font-size=0.4&length=1"
                                    : asset('uploads/user_accounts/'.Auth::user()->profile_image) }}"
                                alt="{{ Auth::user()->username }}"
                                width="42"
                                height="42">
                        </span>

                        <span class="dropdown-info">
                            <span class="subtitle">{{ Auth::user()->first_name. ' '.Auth::user()->last_name }}</span>
                            <span class="description text-muted font-size-sm">{{ Auth::user()->email }}</span>
                        </span>
                    </div>

                    <div class="dropdown-divider"></div>

                    <button onclick="window.location.href='{{ route('account_settings.index') }}'"
                        class="dropdown-item py-2"
                        type="button">
                        <span class="mr-2"><i data-feather="settings"></i></span>
                        <span>Account Settings</span>
                    </button>
                    
                    <button onclick="document.getElementById('logout-form').submit();"
                        class="dropdown-item py-2"
                        type="button">
                        <span class="mr-2"><i data-feather="log-out"></i></span>
                        <span>Logout</span>
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            
        </div>
    </nav>
</div>