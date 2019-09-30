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
use RoboticEvent\Entities\Event as EventObject;
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

		$event = new EventObject();

		if (ArrayUtils::has($payload, 'name')) {
			$name = ArrayUtils::get($payload, 'name');
			if (!Validate::isGenericName($name)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um nome válido'
				]);
			}
			$event->name = $name;
		}

		if (ArrayUtils::has($payload, 'address')) {
			$address = ArrayUtils::get($payload, 'address');
			if (!Validate::isString($address)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um endereço válido'
				]);
			}
			$event->address = $address;
		}

		if (ArrayUtils::has($payload, 'city')) {
			$city = ArrayUtils::get($payload, 'city');
			if (!Validate::isGenericName($city)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma cidade válida'
				]);
			}
			$event->city = $city;
		}

		if (ArrayUtils::has($payload, 'city')) {
			$state = ArrayUtils::get($payload, 'state');
			if (!Validate::isGenericName($state)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um estado válido'
				]);
			}
			$event->state = $state;
		}

		if (ArrayUtils::has($payload, 'country')) {
			$country = ArrayUtils::get($payload, 'country');
			if (!Validate::isGenericName($country)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um país válido'
				]);
			}
			$event->country = $country;
		}

		if (ArrayUtils::has($payload, 'website')) {
			$website = ArrayUtils::get($payload, 'website');
			if (!Validate::isUrl($website)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma url válida'
				]);
			}
			$event->website = $website;
		}

		if (ArrayUtils::has($payload, 'email')) {
			$email = ArrayUtils::get($payload, 'email');
			if (!Validate::isEmail($email)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um email válido'
				]);
			}
			$event->email = $email;
		}

		if (ArrayUtils::has($payload, 'image')) {
			$image = ArrayUtils::get($payload, 'image');
			if (!Validate::isEmail($image)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um caminho válido para imagem'
				]);
			}
			$event->image = $image;
		}

		if (ArrayUtils::has($payload, 'date_start')) {
			$date_start = ArrayUtils::get($payload, 'date_start');
			if (!Validate::isDate($date_start)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma data inicial válida'
				]);
			}
			$event->date_start = $date_start;
		}

		if (ArrayUtils::has($payload, 'date_end')) {
			$date_end = ArrayUtils::get($payload, 'date_end');
			if (!Validate::isDate($date_end)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma data final válida'
				]);
			}
			$event->date_end = $date_end;
		}


		$ok = $event->save();
		// or $event->add();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Não foi possível criar o evento'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Evento criado',
			'event' => [
				'event_id' => $event->id,
				'name' => $event->name,
				'address' => $event->address,
				'city' => $event->city,
				'state' => $event->state,
				'country' => $event->country,
				'website' > $event->website,
				'email' => $event->email,
				'image' => $event->image,
				'date_start' => $event->date_start,
				'date_end' => $event->date_end,
				'date_upd' => $event->date_upd,
				'date_add' => $event->date_add,
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


