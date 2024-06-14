<div class="min-h-screen bg-gray-100 dark:bg-gray-800">

    <!-- Navigation Menu -->
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <!-- Navigation Menu Full Container -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Logo + Menu Items + Hamburger -->
            <div class="relative flex flex-col sm:flex-row px-6 sm:px-0 grow justify-between">
                <!-- Logo -->
                <div class="shrink-0 -ms-4">
                    <a href="{{ route('home')}}">
                        <div class="h-16 w-40 bg-cover bg-[url('../img/politecnico_h.svg')] dark:bg-[url('../img/politecnico_h_white.svg')]"></div>
                    </a>
                </div>

                <!-- Menu Items -->
                <div id="menu-container" class="grow flex flex-col sm:flex-row items-stretch
                invisible h-0 sm:visible sm:h-auto">
                    <!-- Menu Item: Movies -->
                    @can('viewShowcase', App\Models\Movie::class)
                        <x-menus.menu-item
                            content="Movies"
                            href="{{ route('movies.showcase') }}"
                            selected="{{ Route::currentRouteName() == 'movies.showcase'}}"
                        />
                    @endcan

                    <!-- Menu Item: Curricula -->
                    @can('viewGenres', App\Models\Genre::class)
                        <x-menus.submenu-full-width
                            content="Genres"
                            selectable="1"
                            selected="0"
                            uniqueName="submenu_theaters">
                            @foreach ($genre as $genre)
                                <x-menus.submenu-item
                                :content="$genre->name"
                                selectable="1"
                                selected="0"
                                href="{{ route('genre.curriculum', ['genre' => $genre]) }}"/>
                            @endforeach
                        </x-menus.submenu-full-width>
                    @endcan
                    <!-- Menu Item: Screenings -->
                    @can('viewScreenings', App\Models\Screening::class)
                    <x-menus.menu-item
                        content="Screenings"
                        selectable="1"
                        href="{{ route('screenings.index') }}"
                        selected="{{ Route::currentRouteName() == 'screenings.index'}}"
                        />
                    @endcan

                    <!-- Menu Item: Customers -->
                    @can('viewAny', App\Models\Customer::class)
                        <x-menus.menu-item
                            content="Customers"
                            selectable="1"
                            href="{{ route('customers.index') }}"
                            selected="{{ Route::currentRouteName() == 'customers.index'}}"
                            />
                    @endcan

                    {{-- @can('viewAny', App\Models\Customer::class) --}}
                        <x-menus.menu-item
                            content="Administratives & Employees"
                            selectable="1"
                            href="{{ route('administratives.index') }}"
                            selected="{{ Route::currentRouteName() == 'administratives.index'}}"
                            />
                    {{-- @endcan     --}}

                    @if(
                        Gate::check('viewAny', App\Models\Customer::class) ||
                        Gate::check('viewAny', App\Models\User::class) ||
                        Gate::check('viewAny', App\Models\Theater::class) ||
                        Gate::check('viewAny', App\Models\Screening::class)
                        )
                    <!-- Menu Item: Others -->
                    <x-menus.submenu
                        selectable="0"
                        uniqueName="submenu_others"
                        content="More">
                            @can('viewAny', App\Models\Customer::class)
                            <x-menus.submenu-item
                                content="Customer"
                                selectable="0"
                                href="{{ route('customers.index') }}" />
                            @endcan
                            @can('viewAny', App\Models\User::class)
                            <x-menus.submenu-item
                                content="Administratives"
                                selectable="0"
                                href="{{ route('administratives.index') }}" />
                            @endcan
                            <hr>
                            @can('viewAny', App\Models\Theater::class)
                            <x-menus.submenu-item
                                content="Theaters"
                                selectable="0"
                                href="{{ route('theaters.index') }}"/>
                            @endcan

                            <x-menus.submenu-item
                                content="Screenings"
                                href="{{ route('screenings.index') }}"/>
                            <x-menus.submenu-item
                                content="Genres"
                                href="{{ route('genres.index') }}"/>

                    </x-menus.submenu>

                    <x-menus.submenu
                        selectable="0"
                        uniqueName="submenu_others"
                        content="Deleted">
                            @can('viewAny', App\Models\Customer::class)
                            <x-menus.submenu-item
                                content="Customer"
                                selectable="0"
                                href="{{ route('customers.index') }}" />
                            @endcan
                            @can('viewAny', App\Models\User::class)
                            <x-menus.submenu-item
                                content="Administratives"
                                selectable="0"
                                href="{{ route('administratives.index') }}" />
                            @endcan
                            <hr>
                            @can('viewAny', App\Models\Theater::class)
                            <x-menus.submenu-item
                                content="Theaters"
                                selectable="0"
                                href="{{ route('theaters.deleted') }}"/>
                            @endcan

                            <x-menus.submenu-item
                                content="Screenings"
                                href="{{ route('screenings.index') }}"/>
                            

                    </x-menus.submenu>
                    @endif

                    <div class="grow"></div>
                    @php
                        $ls = (Auth::check()) ? count(session()->get('cart') ?? []) : ( Cookie::get('cart') != null ? count(json_decode(Cookie::get('cart'), true) ?? []) : 0);
                    @endphp
                    <!-- Menu Item: Cart -->
                    <x-menus.cart
                    :href="route('cart.show')"
                    selectable=1
                    selected="{{Route::currentRouteName() == 'cart.show'}}"
                    :total="$ls"
                    />

                    @auth
                    <x-menus.submenu
                        selectable="0"
                        uniqueName="submenu_user"
                        >
                        <x-slot:content>
                            <div class="pe-1">

                                <img src="{{ Auth::user()?->photo_filename ? Auth::user()->photoFullUrl : Vite::asset('resources/img/photos/default.png')}}" class="w-11 h-11 min-w-11 min-h-11 rounded-full">
                                {{-- <img src="{{ Auth::user()->photoFullUrl}}" class="w-11 h-11 min-w-11 min-h-11 rounded-full"> --}}
                            </div>
                            {{-- ATENÇÃO - ALTERAR FORMULA DE CALCULO DAS LARGURAS MÁXIMAS QUANDO O MENU FOR ALTERADO --}}
                            <div class="ps-1 sm:max-w-[calc(100vw-39rem)] md:max-w-[calc(100vw-41rem)] lg:max-w-[calc(100vw-46rem)] xl:max-w-[34rem] truncate">
                                {{ Auth::user()->name }}
                            </div>
                        </x-slot>

                        {{-- @can('viewMy', App\Models\Discipline::class)
                        <x-menus.submenu-item
                            content="My Disciplines"
                            selectable="0"
                            href="{{ route('disciplines.my') }}"/>
                        @endcan
                        @can('viewMy', App\Models\Teacher::class)
                        <x-menus.submenu-item
                            content="My Teachers"
                            selectable="0"
                            href="{{ route('teachers.my') }}"/>
                        @endcan
                        @can('viewMy', App\Models\Student::class)
                            <x-menus.submenu-item
                                content="My Students"
                                selectable="0"
                                href="{{ route('students.my') }}"/>
                            <hr>
                        @endcan --}}
                        @auth
                        <hr>
                        {{-- <x-menus.submenu-item
                            content="Profile"
                            selectable="0"
                            :href="match(Auth::user()->type) {
                                'A' => route('administratives.edit', ['administrative' => Auth::user()]),
                                default => route('customers.edit', ['customer' => Auth::user()->customer]),
                            }"/> --}}
                        <x-menus.submenu-item
                            content="Profile"
                            selectable="0"
                            href="{{ route('profile.edit') }}"/>
                        <x-menus.submenu-item
                            content="Change Password"
                            selectable="0"
                            href="{{ route('profile.edit.password') }}"/>
                        @endauth
                        <hr>
                        <form id="form_to_logout_from_menu" method="POST" action="{{ route('logout') }}" class="hidden">
                            @csrf
                        </form>
                        <x-menus.submenu-item
                            content="Log Out"
                            selectable="0"
                            form="form_to_logout_from_menu"/>
                    </x-menus.submenu>
                    @else

                    <!-- Menu Item: Login -->
                    <x-menus.menu-item
                        content="Login"
                        selectable="1"
                        href="{{ route('login') }}"
                        selected="{{ Route::currentRouteName() == 'login'}}"
                        />
                    @endauth
                </div>
                <!-- Hamburger -->
                <div class="absolute right-0 top-0 flex sm:hidden pt-3 pe-3 text-black dark:text-gray-50">
                    <button id="hamburger_btn">
                        <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path id="hamburger_btn_open" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path class="invisible" id="hamburger_btn_close" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
