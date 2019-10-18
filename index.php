<?php 
/**
 * @package    PHP Advanced API Guide
 * @author     Isabelle Minel <isabelleminel@gmail.com>
 * @copyright  2019 TCCSolution
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

 // Namespaces
define('API_NAMESPACE',          'TCCSolution');
define('API_DIR_ROOT',            dirname(__FILE__));
define('API_DIR_CLASSES',         API_DIR_ROOT . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR);
define('API_DIR_CONTROLLERS',     API_DIR_ROOT . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR);

require_once API_DIR_ROOT . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php'; 
require_once API_DIR_ROOT . DIRECTORY_SEPARATOR . 'autoload.php'; 
require_once API_DIR_ROOT . DIRECTORY_SEPARATOR . 'functions.php'; 

require_once API_DIR_ROOT . DIRECTORY_SEPARATOR . 'env.php';

use TCCSolution\Api;
use TCCSolution\Database\DbQuery;
use TCCSolution\Database\DbCore;
use TCCSolution\Database\DbPDOCore;
use TCCSolution\Database\DbMySQLiCore;

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

$api->add(new \TCCSolution\Slim\CorsMiddleware());
$api->config('debug', true);

/**
 * Request Payload
 */
$params = $api->request->get();
$requestPayload = $api->request->post();

$api->group('/api', function () use ($api) {
	$api->group('/v1', function () use ($api) {

		/** Get all Ideas */
		$api->get('/idea?', '\TCCSolution\v1\Idea:getIdeas')->name('get_ideas');
		
		/** Get people by Team */
		//$api->get('/people/team/:teamId:?', '\TCCSolution\v1\Person:getPeople')->name('get_people');

		/** Get people by Event */
		//$api->get('/people/event/:eventId:?', '\TCCSolution\v1\Person:getPeopleByEventId')->name('get_people_by_event_id');

		/** Get person by Email */
		//$api->get('/people/email?', '\TCCSolution\v1\Person:getPersonByEmail')->name('get_people_by_email');

		/** Add an Idea */
		$api->post('/idea?', '\TCCSolution\v1\Idea:addIdea')->name('add_idea');
	
		// /** Get a single Person */
		//$api->get('/people/:personId?', '\TCCSolution\v1\Person:getPerson')->name('get_person');

		// /** Update a single Person */
		//$api->patch('/people/:personId?', '\TCCSolution\v1\Person:updatePerson')->name('update_person');
	
		// /** Delete a Person */
		// $api->delete('/people/:personId?', '\TCCSolution\v1\Person:deletePerson')->name('delete_person');

		// /** search people */
		// $api->get('/people/search?', '\TCCSolution\v1\Person:searchPeople')->name('search_people');
		
		/** Get all Teams */
		//$api->get('/teams?', '\TCCSolution\v1\Team:getTeams')->name('get_teams');
		
		/** Add a Team */
		//$api->post('/teams?', '\TCCSolution\v1\Team:addTeam')->name('add_teams');
	
		/** Get a single Team */
		//$api->get('/teams/:teamId?', '\TCCSolution\v1\Team:getTeam')->name('get_team');

		/** Update a single Team */
		//$api->patch('/teams/:teamId?', '\TCCSolution\v1\Team:updateTeam')->name('update_team');
	
		/** Delete a Team */
		//$api->delete('/teams/:teamId?', '\TCCSolution\v1\Team:deleteTeam')->name('delete_team');

		/** search Teams */
		// $api->get('/teams/search?', '\TCCSolution\v1\Team:searchTeams')->name('search_teams');

		/** Get all Robots */
		//$api->get('/robots?', '\TCCSolution\v1\Robot:getRobots')->name('get_robots');
		
		/** Get Robots by Team */
		//$api->get('/robots/team/:teamId:?', '\TCCSolution\v1\Robot:getRobotsByTeamId')->name('get_robots_by_team_id');

		/** Get Robots by Event */
		//$api->get('/robots/event/:eventId:?', '\TCCSolution\v1\Robot:getRobotsByEventId')->name('get_robots_by_event_id');

		/** Add a Robot */
		//$api->post('/robots?', '\TCCSolution\v1\Robot:addRobot')->name('add_robots');
	
		/** Get a single Robot */
		//$api->get('/robots/:robotId?', '\TCCSolution\v1\Robot:getRobot')->name('get_robot');

		/** Update a single Robot */
		// $api->patch('/robots/:robotId?', '\TCCSolution\v1\Robot:updateRobot')->name('update_robot');
	
		/** Delete a Robot */
		// $api->delete('/robots/:robotId?', '\TCCSolution\v1\Robot:deletePerson')->name('delete_person');

		/** search Robots */
		// $api->get('/robots/search?', '\TCCSolution\v1\Robot:searchRobots')->name('search_robots');

		// /** Get all Events */
		//$api->get('/events?', '\TCCSolution\v1\Event:getEvents')->name('get_events');
		
		// /** Add a Event */
		//$api->post('/events?', '\TCCSolution\v1\Event:addEvent')->name('add_events');
	
		// /** Get a single Event */
		// $api->get('/events/:eventId?', '\TCCSolution\v1\Event:getEvent')->name('get_event');

		// /** Update a single Event */
		// $api->patch('/events/:eventId?', '\TCCSolution\v1\Event:updateEvent')->name('update_event');
	
		// /** Delete a Event */
		// $api->delete('/events/:eventId?', '\TCCSolution\v1\Event:deleteEvent')->name('delete_event');

		// /** search Events */
		// $api->get('/events/search?', '\TCCSolution\v1\Event:searchEvents')->name('search_events');

		/** Asaas */
		//$api->put('/asaas/client/:personId?', '\TCCSolution\v1\Asaas:addClient')->name('add_client');

		/** Get all Ideas */
		//$api->get('/people?', '\TCCSolution\v1\Person:getPeople')->name('get_people');

		/** Grouping Category Endpoints */
		$api->group('/category', function () use ($api) {
		/** Get all Categories */
		$api->get('/?', '\TCCSolution\v1\Category:getCategory')->name('get_category');

		/** Categories by Event */
		//$api->get('/event/:eventId?', '\TCCSolution\v1\Category:getCategoryByEventId')->name('get_category_by_event_id');
		
		/** Add a Category */
		$api->post('/?', '\TCCSolution\v1\Category:addCategory')->name('add_category');

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
