<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  | 	www.your-site.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://www.codeigniter.com/user_guide/general/routing.html
 */

// public
$route['(article)/(:num)/(:num)/(:any)'] = 'article/view/$4';
$route['(article)/page(/:num)?'] = 'article/index$2';
$route['(article)/rss/all.rss'] = 'rss/index';
$route['(article)/rss/(:any).rss'] = 'rss/category/$2';
// admin
$route['article/admin/categories(/:any)?'] = 'admin_categories$1';
$route['article/admin/movies(/:any)?'] = 'admin_movies$1';