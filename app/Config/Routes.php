<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->match(['POST'], 'admin/login', 'Admin\Admin::login');
$routes->match(['POST'], 'admin/artikel', 'Admin\Artikel::index');
$routes->match(['POST'], 'admin/artikel/editartikel/(:num)', 'Admin\Artikel::editartikel/$1');
$routes->match(['POST'], 'admin/page/editartikel/(:num)', 'Admin\Page::editartikel/$1');
$routes->add('admin/logout', 'Admin\Admin::logout');
$routes->get('admin/artikel/editartikel/(:num)', 'Admin\Artikel::editartikel/$1');
$routes->get('admin/page/editartikel/(:num)', 'Admin\Page::editartikel/$1');


$routes->group('admin', ['filter'=>'noauth'], function ($routes) {
    $routes->add(' ', 'Admin\Admin::login');
    $routes->add('login', 'Admin\Admin::login');
    $routes->add('lupapassword', 'Admin\Admin::lupapassword');
    $routes->add('resetpassword', 'Admin\Admin::resetpassword');
}); 

$routes->group('admin', ['filter'=>'auth'], function ($routes) {
    $routes->add('sukses', 'Admin\Admin::sukses');

    $routes->add('artikel', 'Admin\Artikel::index');
    $routes->add('artikel/tambahartikel', 'Admin\Artikel::tambahartikel');
    $routes->add('artikel/editartikel', 'Admin\Artikel::editartikel');

    $routes->add('page', 'Admin\Page::index');
    $routes->add('page/tambahartikel', 'Admin\Page::tambahartikel');
    $routes->add('page/editartikel', 'Admin\Page::editartikel');

    $routes->add('socials', 'Admin\Socials::index');
    $routes->add('akun', 'Admin\Akun::index');
}); 

$routes->add('artikel/(:any)', 'Artikel::index/$1');
$routes->add('tren', 'Tren::index');
$routes->add('event', 'Agenda::index');
$routes->add('kontak', 'About::index');