<?php
require_once 'functions.php';
$message[] = updateTableStatus();
?>

<nav id="navbar">
    <ul class="navbar-items flexbox-col">
        <li class="navbar-logo flexbox-left">
            <a class="navbar-item-inner flexbox">
                <svg class="svg-icon"
                     style="vertical-align: middle;fill: currentColor;overflow: hidden;"
                     viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M477.696 791.04c-14.336 0-25.6-11.264-25.6-25.6v-130.048c0-14.336 11.264-25.6 25.6-25.6s25.6 11.264 25.6 25.6v130.048c0 14.336-11.264 25.6-25.6 25.6zM582.144 1011.712c-14.336 0-25.6-11.264-25.6-25.6v-366.08c0-14.336 11.264-25.6 25.6-25.6s25.6 11.264 25.6 25.6v366.08c0 14.336-11.264 25.6-25.6 25.6zM828.928 1011.712c-14.336 0-25.6-11.264-25.6-25.6v-366.08c0-14.336 11.264-25.6 25.6-25.6s25.6 11.264 25.6 25.6v366.08c0 14.336-11.264 25.6-25.6 25.6zM681.472 791.04c-14.336 0-25.6-11.264-25.6-25.6v-130.048c0-14.336 11.264-25.6 25.6-25.6s25.6 11.264 25.6 25.6v130.048c0 14.336-11.264 25.6-25.6 25.6zM930.304 791.04c-14.336 0-25.6-11.264-25.6-25.6v-130.048c0-14.336 11.264-25.6 25.6-25.6s25.6 11.264 25.6 25.6v130.048c0 14.336-11.264 25.6-25.6 25.6z"/>
                    <path
                        d="M666.624 788.992H484.352c-14.336 0-25.6-11.264-25.6-25.6s11.264-25.6 25.6-25.6h182.272c14.336 0 25.6 11.264 25.6 25.6s-11.264 25.6-25.6 25.6zM819.712 585.216h-1.024c-37.888 0-73.216-12.288-104.448-36.864-28.16 23.04-67.072 36.864-106.496 36.864-38.4 0-73.216-12.288-104.448-36.864-28.16 23.04-67.072 36.864-106.496 36.864-38.4 0-73.216-12.288-104.448-36.864-28.16 23.04-67.072 36.864-106.496 36.864-94.208 0-167.936-73.216-167.936-165.888v-27.648L107.52 105.472C131.584 42.496 180.736 42.496 209.92 42.496h598.016c30.208 0 81.408 0 105.472 57.344l1.024 2.56L1003.52 403.968v15.36c0 42.496-16.896 82.944-47.616 113.152-34.304 34.304-82.432 52.736-136.192 52.736zM711.68 475.136l19.968 19.968c25.6 25.6 55.296 38.912 87.04 38.912 40.448 0 76.288-13.312 100.864-37.888 20.992-20.992 32.256-48.128 32.256-76.8v-8.192L865.28 118.272c-9.728-22.528-24.576-24.576-57.856-24.576H209.92c-28.16 0-42.496 0-53.76 29.184L69.632 399.36v19.968c0 64.512 51.2 114.688 116.736 114.688 34.304 0 67.072-14.336 85.504-36.864l17.92-22.016 19.968 19.968c25.6 25.6 55.296 38.912 87.04 38.912 34.304 0 67.072-14.336 85.504-36.864l17.92-22.016 19.968 19.968c25.6 25.6 55.296 38.912 87.04 38.912 33.792 0 67.072-14.336 85.504-36.864l18.944-22.016z"/>
                    <path
                        d="M441.344 978.432H265.728c-91.648 0-165.888-72.192-165.888-160.768v-253.44c0-14.336 11.264-25.6 25.6-25.6s25.6 11.264 25.6 25.6v253.44c0 60.416 51.712 109.568 114.688 109.568h175.616c14.336 0 25.6 11.264 25.6 25.6s-11.776 25.6-25.6 25.6z"/>
                </svg>
                <span class="link-text">АРМ администратора</span>
            </a>
        </li>
        <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left" href="index.php">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                    <ion-icon name="home-outline"></ion-icon>
                </div>
                <span class="link-text">Панель администратора</span>
            </a>
        </li>
        <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left" href="book_table.php">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                    <ion-icon name="grid-outline"></ion-icon>
                </div>
                <span class="link-text">Бронь столиков</span>
            </a>
        </li>
        <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left" href="tables.php">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                    <ion-icon name="duplicate-outline"></ion-icon>
                </div>
                <span class="link-text">Столики</span>
            </a>
        </li>
        <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left" href="menu.php">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                    <ion-icon name="restaurant-outline"></ion-icon>
                </div>
                <span class="link-text">Меню</span>
            </a>
        </li>
        <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left" href="orders.php">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                    <ion-icon name="list-outline"></ion-icon>
                </div>
                <span class="link-text">Заказы</span>
            </a>
        </li>
        <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left" href="logout.php">
                <div class="navbar-item-inner-icon-wrapper flexbox">
                    <ion-icon name="log-out-outline"></ion-icon>
                </div>
                <span class="link-text">Выйти</span>
            </a>
        </li>
    </ul>
</nav>