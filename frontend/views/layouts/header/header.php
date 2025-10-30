<?php
use common\models\Category;
use common\models\Menu;
?>
<header id="header" class="header">
    <?php $this->registerCsrfMetaTags() ?>
    <div class="header-top-section">
        <div class="container">
            <div class="header-top">
                <?= Menu::getUserMenu() ?>
                <div class="header-contact d-none d-lg-block">
                    <a href="#">
                        <span>Need help? Call us:</span>
                        <span class="contact-number">+ 00645 4568</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-center-section d-none d-lg-block">
        <div class="container">
            <div class="header-center">
                <div class="logo">
                    <a href="/">
                        <img src="/images/logos/logoV5.png" alt="logo">
                    </a>
                </div>
                <div class="header-cart-items">
                    <div class="header-search">
                        <button class="header-search-btn" onclick="modalAction('.search')">
                            <span>
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.9708 16.4151C12.5227 17.4021 10.9758 17.9723 9.27353 18.0062C5.58462 18.0802 2.75802 16.483 1.05056 13.1945C-1.76315 7.77253 1.33485 1.37571 7.25086 0.167548C12.2281 -0.848249 17.2053 2.87895 17.7198 7.98579C17.9182 9.95558 17.5566 11.7939 16.5852 13.5061C16.4512 13.742 16.483 13.8725 16.6651 14.0553C18.2412 15.6386 19.8112 17.2272 21.3735 18.8244C22.1826 19.6513 22.2058 20.7559 21.456 21.4932C20.7697 22.1678 19.7047 22.1747 18.9764 21.4793C18.3623 20.8917 17.7774 20.2737 17.1796 19.6688C16.118 18.5929 15.0564 17.5153 13.9708 16.4151ZM2.89545 9.0364C2.91692 12.4172 5.59664 15.1164 8.91967 15.1042C12.2384 15.092 14.9138 12.3493 14.8889 8.98505C14.864 5.63213 12.1826 2.92508 8.89047 2.92857C5.58204 2.93118 2.87397 5.68958 2.89545 9.0364Z"
                                        fill="black"></path>
                                </svg>
                            </span>
                        </button>
                        <div class="modal-wrapper search">
                            <div onclick="modalAction('.search')" class="anywhere-away"></div>

                            <!-- change this -->
                            <div class="modal-main">
                                <div class="wrapper-close-btn" onclick="modalAction('.search')">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="red" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="wrapper-main">
                                    <div class="search-section">
                                        <input type="text" placeholder="Search Products.........">
                                        <div class="divider"></div>
                                        <button type="button">All Categories</button>
                                        <a href="#" class="shop-btn">Search</a>
                                    </div>
                                </div>
                            </div>

                            <!-- change this -->

                        </div>
                    </div>
                    <div class="header-compaire">
                        <a href="compaire.html" class="cart-item">
                            <div class="cart-with-icon">
                                <img src="/images/analysis.png" alt="Сравнение" class="cart-img">
                                <span class="cart-count">3</span>
                            </div>

                            </span>
                            <span class="cart-text ">
                                Сравнение
                            </span>
                        </a>
                    </div>
                    <div class="header-cart">
                        <a href="/shop-cart/default/index" class="cart-item">
                            <div class="cart-with-icon">
                                <img src="/images/cart.png" alt="Корзина" class="cart-img">
                                <span class="cart-count">3</span>
                            </div>
                            <span class="cart-text">
                                Корзина
                            </span>
                        </a>
                    </div>
                    <div class="header-user">
                        <a href="user-profile.html">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                    class="fill-current">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path
                                        d="M20 22H4v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2zm-8-9a6 6 0 1 1 0-12 6 6 0 0 1 0 12z">
                                    </path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="mobile-menu d-block d-lg-none">
        <div class="mobile-menu-header d-flex justify-content-between align-items-center">
            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
                aria-controls="offcanvasWithBothOptions">
                <span>
                    <svg width="14" height="9" viewBox="0 0 14 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="14" height="1" fill="#1D1D1D"></rect>
                        <rect y="8" width="14" height="1" fill="#1D1D1D"></rect>
                        <rect y="4" width="10" height="1" fill="#1D1D1D"></rect>
                    </svg>
                </span>
            </button>
            <a href="/" class="mobile-header-logo">
                <img src="/images/logos/logoV5.png" alt="logo">
            </a>
            <a href="/shop-cart/default/index" class="header-cart cart-item">
                <div class="cart-with-icon">
                                <img src="/images/cart.png" alt="Корзина" class="cart-img">
                                <span class="cart-count">3</span>
                            </div>
            </a>
        </div>

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions">

            <div class="offcanvas-body">
                <div class="header-top">
                    <div class="header-cart ">
                        <div class="header-compaire">
                            <a href="/shop-compaire/default/index" class="cart-item">
                                <div class="cart-with-icon">
                                <img src="/images/analysis.png" alt="Сравнение" class="cart-img">
                                <span class="cart-count">3</span>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="shop-btn">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">

                        </button>
                    </div>
                </div>
                <div class="header-input">
                    <input type="text" placeholder="Search....">
                    <span>
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.9708 16.4151C12.5227 17.4021 10.9758 17.9723 9.27353 18.0062C5.58462 18.0802 2.75802 16.483 1.05056 13.1945C-1.76315 7.77253 1.33485 1.37571 7.25086 0.167548C12.2281 -0.848249 17.2053 2.87895 17.7198 7.98579C17.9182 9.95558 17.5566 11.7939 16.5852 13.5061C16.4512 13.742 16.483 13.8725 16.6651 14.0553C18.2412 15.6386 19.8112 17.2272 21.3735 18.8244C22.1826 19.6513 22.2058 20.7559 21.456 21.4932C20.7697 22.1678 19.7047 22.1747 18.9764 21.4793C18.3623 20.8917 17.7774 20.2737 17.1796 19.6688C16.118 18.5929 15.0564 17.5153 13.9708 16.4151ZM2.89545 9.0364C2.91692 12.4172 5.59664 15.1164 8.91967 15.1042C12.2384 15.092 14.9138 12.3493 14.8889 8.98505C14.864 5.63213 12.1826 2.92508 8.89047 2.92857C5.58204 2.93118 2.87397 5.68958 2.89545 9.0364Z"
                                fill="black"></path>
                        </svg>
                    </span>
                </div>

                <div class="category-dropdown">
                    <?= Category::getCategoryMenu() ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="header-bottom d-lg-block d-none">
        <div class="container">
            <div class="header-nav">
                <div class="category-menu-section position-relative">
                    <div class="empty position-fixed" onclick="tooglmenu()"></div>
                    <button class="dropdown-btn" onclick="tooglmenu()">
                        <span class="dropdown-icon">
                            <svg width="14" height="9" viewBox="0 0 14 9" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="14" height="1"></rect>
                                <rect y="8" width="14" height="1"></rect>
                                <rect y="4" width="10" height="1"></rect>
                            </svg>
                        </span>
                        <span class="list-text">
                            All Categories
                        </span>
                    </button>
                    <div class="category-dropdown position-absolute" id="subMenu" style="--max-height: 484px;">
                        <?= Category::getCategoryMenu() ?>

                    </div>
                </div>
                <div class="header-nav-menu">
                    <?= Menu::getMainMenuItems() ?>
                </div>
                <div class="header-vendor-btn">
                    <a href="become-vendor.html" class="shop-btn">
                        <span class="list-text shop-text">Became Vendor</span>
                        <span class="icon">
                            <svg width="24" height="16" viewBox="0 0 24 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20.257 7.07205C20.038 7.07205 19.8474 7.07205 19.6563 7.07205C17.4825 7.07205 15.3086 7.07205 13.1352 7.07205C10.1545 7.07205 7.17336 7.0725 4.19265 7.0725C3.30392 7.0725 2.41519 7.07024 1.52646 7.07295C1.12124 7.07431 0.809811 7.25265 0.625785 7.62651C0.43866 8.00623 0.488204 8.37556 0.737704 8.70426C0.932347 8.96027 1.20529 9.08173 1.52867 9.08037C2.20948 9.07766 2.8903 9.07902 3.57111 9.07902C5.95285 9.07902 8.33415 9.07902 10.7159 9.07902C13.782 9.07902 16.8485 9.07902 19.9146 9.07902C20.0274 9.07902 20.1398 9.07902 20.2822 9.07902C20.1871 9.18332 20.1141 9.26865 20.0358 9.34857C19.5656 9.82672 19.0922 10.3022 18.6229 10.7812C18.1363 11.2779 17.6541 11.7791 17.1675 12.2757C16.4942 12.9634 15.8116 13.6415 15.1476 14.3391C14.9096 14.5893 14.8455 14.9157 14.9406 15.2575C15.156 16.0305 16.0567 16.2499 16.6119 15.6769C17.4342 14.8286 18.2655 13.9892 19.0927 13.1458C19.6948 12.5317 20.2968 11.9172 20.8985 11.3023C21.5952 10.5902 22.2911 9.87729 22.9878 9.1648C23.1059 9.04425 23.2249 8.9246 23.3435 8.8045C23.6903 8.45367 23.7239 7.84278 23.3943 7.4766C22.998 7.03683 22.5852 6.61241 22.1756 6.18573C21.7965 5.79066 21.4134 5.39965 21.0303 5.00909C20.6733 4.64473 20.3132 4.28306 19.9553 3.91915C19.6147 3.57284 19.2754 3.22563 18.9356 2.87887C18.5154 2.44948 18.0951 2.01964 17.6744 1.5907C17.2511 1.15861 16.8198 0.734188 16.4057 0.29261C16.0363 -0.101559 15.3697 -0.0816927 15.0344 0.257392C14.6238 0.672782 14.5999 1.26381 14.995 1.68552C15.3378 2.0517 15.6957 2.40342 16.0465 2.76192C16.929 3.66449 17.8111 4.56797 18.6937 5.47054C19.1829 5.97081 19.6735 6.47018 20.1632 6.97046C20.1885 6.99574 20.2123 7.02329 20.257 7.07205Z">
                                </path>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>