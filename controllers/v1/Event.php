<?php
/**
 * @package    PHP Advanced API Guide
 * @author     Davison Pro <davisonpro.coder@gmail.com>
 * @copyright  2019 DavisonPro
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

namespace RoboticEvent\v1;

use Db;
use RoboticEvent\Route;
use RoboticEvent\Database\DbQuery;
use RoboticEvent\Event\Event as EventObject;
use RoboticEvent\Event\Category as CategoryObject;
use RoboticEvent\Util\ArrayUtils;
use RoboticEvent\Validate;

class Event extends Route {

	public function getEvents() {
		$api = $this->api;

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('event.*');
		// Build FROM
		$sql->from('event', 'event');
		$events = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'events' => $events
		]);
	}

	public function addEvent() {
		$api = $this->api;
		$payload = $api->request()->post(); 

		$name = ArrayUtils::get($payload, 'name');
		$description = ArrayUtils::get($payload, 'description');
		$price = ArrayUtils::get($payload, 'price');
		$category_id = ArrayUtils::get($payload, 'category_id');

		if (!Validate::isGenericName($name)) {
			return $api->response([
				'success' => false,
				'message' => 'Enter a valid event name'
			]);
		}

		if (!Validate::isCleanHtml($description)) {
			return $api->response([
				'success' => false,
				'message' => 'Enter a valid description of the event'
			]);
		}

		if (!Validate::isPrice($price)) {
			return $api->response([
				'success' => false,
				'message' => 'Enter a valid price of the event'
			]);
		}

		if(!Validate::isInt($category_id)) {
			return $api->response([
				'success' => false,
				'message' => 'Enter a valid category ID of the event'
			]);
		}

		$category = new CategoryObject( (int) $category_id );
		if (!Validate::isLoadedObject($category)) {
			return $api->response([
				'success' => false,
				'message' => 'The category ID (' . $category_id . ') does not exist'
			]);
		}

		$event = new EventObject();
		$event->name = $name;
		$event->description = $description;
		$event->price = (float) $price;
		$event->category_id = $category->id;

		$ok = $event->save();
		// or $event->add();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to create event'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Event was Created',
			'event' => [
				'event_id' => $event->id,
				'name' => $event->id,
				'description' => $event->description,
				'price' => (float) $event->price,
				'category' => [
					'category_id' => $category->id,
					'name' => $category->name,
					'description' => $category->description,
				],
			]
		]);
	}

	public function getEvent( $eventId ) {
		$api = $this->api;

		$event = new EventObject( (int) $eventId );
		if(!Validate::isLoadedObject($event)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Event was not found'
			]);
		}
		
		$category = new CategoryObject( $event->category_id );

		return $api->response([
			'success' => true,
			'message' => 'Event was Created',
			'event' => [
				'event_id' => $event->id,
				'name' => $event->name,
				'description' => $event->description,
				'price' => (float) $event->price,
				'category' => [
					'category_id' => $category->id,
					'name' => $category->name,
					'description' => $category->description,
				],
			]
		]);
	}

	public function updateEvent($eventId ) {
		$api = $this->api;
		$payload = $api->request()->post(); 

		$event = new EventObject( (int) $eventId );
		if(!Validate::isLoadedObject($event)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Event was not found'
			]);
		}

		if (ArrayUtils::has($payload, 'name')) {
			$name = ArrayUtils::get($payload, 'name');
			if ( !Validate::isGenericName($name) ) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid event name'
				]);
			}

			$event->name = $name;
		}

		if (ArrayUtils::has($payload, 'description')) {
			$description = ArrayUtils::get($payload, 'description');
			if (!Validate::isCleanHtml($description)) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid description of the event'
				]);
			}

			$event->description = $description;
		}

		if (ArrayUtils::has($payload, 'description')) {
			$price = ArrayUtils::get($payload, 'price');
			if (!Validate::isPrice($price)) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid price of the event'
				]);
			}

			$event->price = $price;
		}

		if (ArrayUtils::has($payload, 'category_id')) {
			$category_id = ArrayUtils::get($payload, 'category_id');
			if(!Validate::isInt($category_id)) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid category ID of the event'
				]);
			}

			$category = new CategoryObject( (int) $category_id );
			if (!Validate::isLoadedObject($category)) {
				return $api->response([
					'success' => false,
					'message' => 'The category ID (' . $category_id . ') does not exist'
				]);
			}

			$event->category_id = $category->id;
		}

		return $api->response([
			'success' => false,
			'message' => 'Unable to update event'
		]);

		$ok = $event->save();
		// or event->update()
		
		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to update event'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Event updated successfully'
		]);
	}

	public function deleteEvent( $eventId ) {
		$api = $this->api;

		$event = new EventObject( (int) $eventId );
		if(!Validate::isLoadedObject($event)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Event was not found'
			]);
		}

		$ok = $event->delete();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to delete event'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Event deleted successfully'
		]);
	}
	
	public function searchEvents() {
		$api = $this->api;
		$params = $api->request()->get(); 

		$name = ArrayUtils::get($params, 'name');
		$description = ArrayUtils::get($params, 'description');

		if(!$name && !$description) {
			return $api->response([
				'success' => false,
				'message' => 'Enter name or description of the event'
			]);
		}

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('event.*');
		// Build FROM
		$sql->from('event', 'event');

		// prevent sql from searching a NULL value if wither name or description is not provided eg. WHERE name = null
		$where_clause = array();
		if($name) {
			$where_clause[] = 'event.name LIKE \'%' . pSQL($name) . '%\'';
		}

		if ($description) {
			$where_clause[] = 'event.description LIKE \'%' . pSQL($description) . '%\'';
		}

		// join the search terms
		$where_clause = implode(' OR ', $where_clause);

		// Build WHERE
		$sql->where($where_clause);

		$events = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'events' => $events
		]);
	}
}


