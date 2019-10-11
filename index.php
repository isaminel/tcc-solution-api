<?php 
/**
 * @package    PHP Advanced API Guide
 * @author     Davison Pro <davisonpro.coder@gmail.com>
 * @copyright  2019 DavisonPro
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

 // Namespaces
define('API_NAMESPACE',          'TccSolution');
define('API_DIR_ROOT',            dirname(__FILE__));
define('API_DIR_CLASSES',         API_DIR_ROOT . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR);
define('API_DIR_CONTROLLERS',     API_DIR_ROOT . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR);

require_once API_DIR_ROOT . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'; 
require_once API_DIR_ROOT . DIRECTORY_SEPARATOR . 'autoload.php'; 
require_once API_DIR_ROOT . DIRECTORY_SEPARATOR . 'functions.php'; 

require_once API_DIR_ROOT . DIRECTORY_SEPARATOR . 'env.php';

use TccSolution\Api;
use TccSolution\Database\DbQuery;
use TccSolution\Database\DbCore;
use TccSolution\Database\DbPDOCore;
use TccSolution\Database\DbMySQLiCore;

abstract class Db extends DbCore {};
class DbPDO extends DbPDOCore {};
class DbMySQLi extends DbMySQLiCore {};

/** CORS Middleware */
$config = array(
	/** MySQL database name */
	'database_name' => $_ENV['DB_NAME'],
	/** MySQL hostname */
	'database_host' => $_ENV['DB_HOST'],
	/** MySQL database username */
	'database_user' => $_ENV['DB_USER'],
	/** MySQL database password */ 
	'database_password' => $_ENV['DB_PASSWORD'],
	/** MySQL Database Table prefix. */
	'database_prefix' => '',
	/** preferred database */
	'database_engine' => 'DbPDO',
	/** API CORS */
	'cors' => [
		'enabled' => true,
		'origin' => '*', // can be a comma separated value or array of hosts
		'headers' => [
			'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Authorization, Cache-Control, Content-Type, Access-Control-Allow-Origin',
			'Access-Control-Allow-Credentials' => 'true',
			'Access-Control-Allow-Methods' => 'GET,PUT,POST,DELETE,OPTIONS,PATCH'
		]
	]
);

define('_DB_SERVER_', $config['database_host']);
define('_DB_NAME_', $config['database_name']);

define('_DB_USER_', $config['database_user']);
define('_DB_PASSWD_', $config['database_password']);
define('_DB_PREFIX_',  $config['database_prefix']);
define('_MYSQL_ENGINE_',  $config['database_engine']);

/** API Construct */
$api = new Api([
	'mode' => 'development',
    'debug' => true
]);

$api->add(new \TccSolution\Slim\CorsMiddleware());
$api->config('debug', true);

/**
 * Request Payload
 */
$params = $api->request->get();
$requestPayload = $api->request->post();

$api->group('/api', function () use ($api) {
	$api->group('/v1', function () use ($api) {
		/** Get all People */
		//$api->get('/people?', '\TccSolution\v1\Person:getPeople')->name('get_people');
		
		/** Get people by Team */
		//$api->get('/people/team/:teamId:?', '\TccSolution\v1\Person:getPeople')->name('get_people');

		/** Get people by Event */
		//$api->get('/people/event/:eventId:?', '\TccSolution\v1\Person:getPeopleByEventId')->name('get_people_by_event_id');

		/** Get person by Email */
		//$api->get('/people/email?', '\TccSolution\v1\Person:getPersonByEmail')->name('get_people_by_email');

		/** Add a Person */
		//$api->post('/people?', '\TccSolution\v1\Person:addPerson')->name('add_people');
	
		// /** Get a single Person */
		//$api->get('/people/:personId?', '\TccSolution\v1\Person:getPerson')->name('get_person');

		// /** Update a single Person */
		//$api->patch('/people/:personId?', '\TccSolution\v1\Person:updatePerson')->name('update_person');
	
		// /** Delete a Person */
		// $api->delete('/people/:personId?', '\TccSolution\v1\Person:deletePerson')->name('delete_person');

		// /** search people */
		// $api->get('/people/search?', '\TccSolution\v1\Person:searchPeople')->name('search_people');
		
		/** Get all Teams */
		//$api->get('/teams?', '\TccSolution\v1\Team:getTeams')->name('get_teams');
		
		/** Add a Team */
		//$api->post('/teams?', '\TccSolution\v1\Team:addTeam')->name('add_teams');
	
		/** Get a single Team */
		//$api->get('/teams/:teamId?', '\TccSolution\v1\Team:getTeam')->name('get_team');

		/** Update a single Team */
		//$api->patch('/teams/:teamId?', '\TccSolution\v1\Team:updateTeam')->name('update_team');
	
		/** Delete a Team */
		//$api->delete('/teams/:teamId?', '\TccSolution\v1\Team:deleteTeam')->name('delete_team');

		/** search Teams */
		// $api->get('/teams/search?', '\TccSolution\v1\Team:searchTeams')->name('search_teams');

		/** Get all Robots */
		//$api->get('/robots?', '\TccSolution\v1\Robot:getRobots')->name('get_robots');
		
		/** Get Robots by Team */
		//$api->get('/robots/team/:teamId:?', '\TccSolution\v1\Robot:getRobotsByTeamId')->name('get_robots_by_team_id');

		/** Get Robots by Event */
		//$api->get('/robots/event/:eventId:?', '\TccSolution\v1\Robot:getRobotsByEventId')->name('get_robots_by_event_id');

		/** Add a Robot */
		//$api->post('/robots?', '\TccSolution\v1\Robot:addRobot')->name('add_robots');
	
		/** Get a single Robot */
		//$api->get('/robots/:robotId?', '\TccSolution\v1\Robot:getRobot')->name('get_robot');

		/** Update a single Robot */
		// $api->patch('/robots/:robotId?', '\TccSolution\v1\Robot:updateRobot')->name('update_robot');
	
		/** Delete a Robot */
		// $api->delete('/robots/:robotId?', '\TccSolution\v1\Robot:deletePerson')->name('delete_person');

		/** search Robots */
		// $api->get('/robots/search?', '\TccSolution\v1\Robot:searchRobots')->name('search_robots');

		// /** Get all Events */
		//$api->get('/events?', '\TccSolution\v1\Event:getEvents')->name('get_events');
		
		// /** Add a Event */
		//$api->post('/events?', '\TccSolution\v1\Event:addEvent')->name('add_events');
	
		// /** Get a single Event */
		// $api->get('/events/:eventId?', '\TccSolution\v1\Event:getEvent')->name('get_event');

		// /** Update a single Event */
		// $api->patch('/events/:eventId?', '\TccSolution\v1\Event:updateEvent')->name('update_event');
	
		// /** Delete a Event */
		// $api->delete('/events/:eventId?', '\TccSolution\v1\Event:deleteEvent')->name('delete_event');

		// /** search Events */
		// $api->get('/events/search?', '\TccSolution\v1\Event:searchEvents')->name('search_events');

		/** Asaas */
		//$api->put('/asaas/client/:personId?', '\TccSolution\v1\Asaas:addClient')->name('add_client');


		/** Grouping Category Endpoints */
		$api->group('/category', function () use ($api) {
			/** Get all Categories */
			$api->get('/?', '\TccSolution\v1\Category:getCategory')->name('get_category');

			/** Categories by Event */
			//$api->get('/event/:eventId?', '\TccSolution\v1\Category:getCategoryByEventId')->name('get_category_by_event_id');
			
			/** Add a Category */
			$api->post('/?', '\TccSolution\v1\Category:addCategory')->name('add_category');
	
		});
		
	});
});

$api->notFound(function () use ($api) {
	$api->response([
		'success' => false,
		'error' => 'Resource Not Found'
	]);
	return $api->stop();
});

$api->response()->header('Content-Type', 'application/json; charset=utf-8');
$api->run();
