<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Plugin;
use Cake\Routing\Router;
use Cake\Network;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
$req = new Network\Request();

Router::defaultRouteClass('DashedRoute');
Router::scope('/api/v1', function ($routes) {
    $routes->connect('sync/download', ['controller' => 'Sync', 'action' => 'download']);
    $routes->connect('sqlite/getdb', ['controller' => 'Sqlite', 'action' => 'getDB']);
    $routes->connect('images/amazonupload', ['controller' => 'Images', 'action' => 'amazonUpload']);
    $routes->connect('images/upload1', ['controller' => 'Images', 'action' => 'upload1']);
    $routes->connect('app/backupmysqldump', ['controller' => 'App', 'action' => 'backupMysqldump']);
    $routes->fallbacks('DashedRoute');
});





//Travel Web App Endpoints     
Router::scope('/api/v1', function ($routes) {
    $routes->connect('/downloadDb', ['controller' => 'DownloadDb', 'action' => 'index']);
    $routes->connect('/download', ['controller' => 'Download', 'action' => 'index']);
    $routes->connect('/upload', ['controller' => 'Upload', 'action' => 'up']);
    $routes->connect('/imagesupload', ['controller' => 'imagesUpload', 'action' => 'index']);
    $routes->connect('/updateuser', ['controller' => 'UpdateUser', 'action' => 'update']);
    $routes->connect('/sendotp', ['controller' => 'User', 'action' => 'sendOtp']);
});

//Travel website Endpoints
Router::scope('/', function ($routes) {
    $routes->connect('login/validate', ['controller' => 'LoginForm', 'action' => 'validate',]);
    $routes->connect('home/adminpanel', ['controller' => 'HomeForm', 'action' => 'adminPanel',]);
    $routes->connect('privacyterms', ['controller' => 'HomeForm', 'action' => 'privacyTerms',]);
    $routes->connect('destination/index', ['controller' => 'DestinationForm', 'action' => 'index',]);
    $routes->connect('destination/add', ['controller' => 'DestinationForm', 'action' => 'add',]);
    $routes->connect('destination/edit', ['controller' => 'DestinationForm', 'action' => 'edit',]);
    $routes->connect('question/index', ['controller' => 'QuestionForm', 'action' => 'index']);
    $routes->connect('question/add', ['controller' => 'QuestionForm', 'action' => 'add']);
    $routes->connect('question/edit', ['controller' => 'QuestionForm', 'action' => 'edit']);
    $routes->connect('configuration/index', ['controller' => 'ConfigurationForm', 'action' => 'index']);
    $routes->connect('configuration/add', ['controller' => 'ConfigurationForm', 'action' => 'add']);
    $routes->connect('configuration/edit', ['controller' => 'ConfigurationForm', 'action' => 'edit']);
    
});


Router::connect('logout', ['controller' => 'Form', 'action' => 'logout']);
/**
 * Here, we are connecting '/' (base path) to a controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, src/Template/Pages/home.ctp)...
 */

//Router::connect('/', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/', ['controller' => 'LoginForm', 'action' => 'index']);


/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
/**
 * Connect catchall routes for all controllers.
 *
 * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
 *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
 *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
 *
 * Any route class can be used with this method, such as:
 * - DashedRoute
 * - InflectedRoute
 * - Route
 * - Or your own route class
 *
 * You can remove these routes once you've connected the
 * routes you want in your application.
 */
//$routes->fallbacks('DashedRoute');
//});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
