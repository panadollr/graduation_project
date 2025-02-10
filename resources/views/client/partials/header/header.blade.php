<header class="header header-10 header-intro-clearance" style="border-bottom: 1px dashed #1f3bb3;">
    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('client/assets/images/logo.png') }}" alt="" width="105"
                        height="25">
                </a>

                <div>
                    @include('client.partials.header.category-dropdown')
                </div>

            </div><!-- End .header-left -->


            <div class="header-center">
                {{-- @livewire('client.product-search') --}}
            </div>

            <div class="header-right">

                <div class="account">
                    <a
                        @auth href="{{ route('account.index') }}" title="Tài khoản"
                       @else
                       href="#signin-modal" data-toggle="modal" @endauth>
                        <div class="icon">
                            <i class="icon-user"></i>
                        </div>
                        <p style='font-family: sans-serif;'>@auth Tài khoản của tôi
                            @else
                            Đăng nhập @endauth
                        </p>
                    </a>
                </div>

                <div class="header-dropdown-link">
                    {{-- <livewire:client.dropdown-cart /> --}}

                </div>
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->


</header><!-- End .header -->
