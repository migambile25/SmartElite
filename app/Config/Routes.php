<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes
$routes->get('/', 'Home::index');
$routes->get('/forms', 'PublicForms::index');
$routes->get('/register/(:segment)', 'Register::index/$1');
$routes->post('/register/(:segment)', 'Register::submit/$1');
$routes->get('/register/(:segment)/success', 'Register::success/$1');

// Admin routes
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    // Dashboard
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    // Forms management
    $routes->get('forms', 'Admin\Forms::index');
    $routes->get('forms/create', 'Admin\Forms::create');
    $routes->post('forms/store', 'Admin\Forms::store');
    $routes->get('forms/edit/(:num)', 'Admin\Forms::edit/$1');
    $routes->post('forms/update/(:num)', 'Admin\Forms::update/$1');
    $routes->get('forms/delete/(:num)', 'Admin\Forms::delete/$1');
    $routes->post('forms/delete/(:num)', 'Admin\Forms::delete/$1');
    $routes->get('forms/restore/(:num)', 'Admin\Forms::restore/$1');
    $routes->post('forms/restore/(:num)', 'Admin\Forms::restore/$1');
    $routes->get('forms/permanent-delete/(:num)', 'Admin\Forms::permanentDelete/$1');
    $routes->post('forms/permanent-delete/(:num)', 'Admin\Forms::permanentDelete/$1');
    
    // Form fields management
        $routes->get('forms/(:num)/fields', 'Admin\FormFields::index/$1');
        $routes->get('forms/(:num)/fields/create', 'Admin\FormFields::create/$1');
        $routes->post('forms/(:num)/fields/store', 'Admin\FormFields::store/$1');
        $routes->get('forms/(:num)/fields/bulk-create', 'Admin\FormFields::bulkCreate/$1');
        $routes->post('forms/(:num)/fields/bulk-store', 'Admin\FormFields::bulkStore/$1');
        $routes->get('forms/(:num)/fields/edit/(:num)', 'Admin\FormFields::edit/$1/$2');
        $routes->post('forms/(:num)/fields/update/(:num)', 'Admin\FormFields::update/$1/$2');
        $routes->get('forms/(:num)/fields/delete/(:num)', 'Admin\FormFields::delete/$1/$2');
        $routes->post('forms/(:num)/fields/delete/(:num)', 'Admin\FormFields::delete/$1/$2');
        $routes->get('forms/(:num)/fields/restore/(:num)', 'Admin\FormFields::restore/$1/$2');
        $routes->post('forms/(:num)/fields/restore/(:num)', 'Admin\FormFields::restore/$1/$2');
        $routes->get('forms/(:num)/fields/permanent-delete/(:num)', 'Admin\FormFields::permanentDelete/$1/$2');
        $routes->post('forms/(:num)/fields/permanent-delete/(:num)', 'Admin\FormFields::permanentDelete/$1/$2');
        $routes->post('forms/(:num)/fields/reorder', 'Admin\FormFields::reorder/$1');
    
    // Form submissions
    $routes->get('forms/(:num)/submissions', 'Admin\Submissions::index/$1');
    $routes->get('forms/(:num)/submissions/(:num)', 'Admin\Submissions::view/$1/$2');
    $routes->get('forms/(:num)/submissions/export', 'Admin\Submissions::export/$1');
    $routes->get('forms/(:num)/submissions/delete/(:num)', 'Admin\Submissions::delete/$1/$2');
    $routes->post('forms/(:num)/submissions/delete/(:num)', 'Admin\Submissions::delete/$1/$2');
    $routes->get('forms/(:num)/submissions/restore/(:num)', 'Admin\Submissions::restore/$1/$2');
    $routes->post('forms/(:num)/submissions/restore/(:num)', 'Admin\Submissions::restore/$1/$2');
    $routes->get('forms/(:num)/submissions/permanent-delete/(:num)', 'Admin\Submissions::permanentDelete/$1/$2');
    $routes->post('forms/(:num)/submissions/permanent-delete/(:num)', 'Admin\Submissions::permanentDelete/$1/$2');
});

// Authentication routes
$routes->get('admin/login', 'Auth::login');
$routes->post('admin/login', 'Auth::authenticate');
$routes->get('admin/logout', 'Auth::logout');
