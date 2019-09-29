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
use RoboticEvent\Entities\Person as PersonObject;
use RoboticEvent\Entities\Team as TeamObject;
use RoboticEvent\Util\ArrayUtils;
use RoboticEvent\Validate;

class Person extends Route {

	public function getPeople() {
		$api = $this->api;

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('person.*');
		// Build FROM
		$sql->from('person', 'person');
		$people = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'people' => $people
		]);
	}

	public function getPeopleByTeamId( $teamId ) {
		$api = $this->api;

		$sql = new DbQuery();
		$sql->select('person.*');
		$sql->from('person');

		$sql->where('team_id = ' . pSQL($teamId));

		$people = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'people' => $people
		]);
	}	
	
	public function getPeopleByEventId( $eventId ) {
		$api = $this->api;

		$sql = new DbQuery();
		$sql->select('person.*');
		$sql->from('person');
		$sql->from('event');
		$sql->from('event_person');

		$sql->where('event_person.person_id = person.person_id');
		$sql->where('event_person.event_id = event.event_id');
		$sql->where('event.event_id = ' . pSQL($eventId));

		$people = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'people' => $people
		]);
	}

	public function addPerson() {
		$api = $this->api;
		$payload = $api->request()->post(); 

		
		$team_id = ArrayUtils::get($payload, 'team_id');
		$event_id = ArrayUtils::get($payload, 'event_id');
		$person_type_id = ArrayUtils::get($payload, 'person_type_id');

		$person = new PersonObject();

		if (ArrayUtils::has($payload, 'name')) {
			$name = ArrayUtils::get($payload, 'name');
			if (!Validate::isGenericName($name)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um nome válido'
				]);
			}

			$person->name = $name;
		}

		if (ArrayUtils::has($payload, 'email')) {
			$email = ArrayUtils::get($payload, 'email');
			if (!Validate::isEmail($email)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um email válido'
				]);
			}

			$person->email = $email;
		}
		
		if (ArrayUtils::has($payload, 'cpf')) {
			$cpf = ArrayUtils::get($payload, 'cpf');
			if (!Validate::isCpf($cpf)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um cpf válido'
				]);
			}

			$person->cpf = $cpf;
		}

		if (ArrayUtils::has($payload, 'rg')) {
			$rg = ArrayUtils::get($payload, 'rg');
			if (!Validate::isRg($rg)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um rg válido'
				]);
			}

			$person->rg = $rg;
		}

		if (ArrayUtils::has($payload, 'rg')) {
			$date_of_birth = ArrayUtils::get($payload, 'date_of_birth');
			if (!Validate::isDate($date_of_birth)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma data de nascimento válida'
				]);
			}

			$person->date_of_birth = $date_of_birth;
		}

		if (ArrayUtils::has($payload, 'phone')) {
			$phone = ArrayUtils::get($payload, 'phone');

			if (!Validate::isString($phone)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma string válida para o telefone'
				]);
			}

			$person->phone = $phone;
		}

		if (ArrayUtils::has($payload, 'photo')) {
			$phone = ArrayUtils::get($payload, 'photo');

			if (!Validate::isString($photo)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma string válida para o caminho da foto'
				]);
			}

			$person->photo = $photo;
		}

		if(!Validate::isInt($team_id)) {
			return $api->response([
				'success' => false,
				'message' => 'Insira uma equipe válida para a pessoa'
			]);
		}

		$team = new TeamObject( (int) $team_id );
		if (!Validate::isLoadedObject($team)) {
			return $api->response([
				'success' => false,
				'message' => 'O ID de equipe (' . $team_id . ') não existe.'
			]);
		}

		$person->date_add = date('Y-m-d H:m:s', time());
		$person->team_id = $team->id;
		$person->person_type_id = $person_type_id;

		$ok = $person->save();
		// or $person->add();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Não foi possível criar a Pessoa'
			]);
		}

		if ($event_id != null) {
			if (!Db::getInstance()->insert('event_person', array(
				'event_id' => $event_id,
				'person_id' => $person->id
			))) {
				return $api->response([
					'success' => false,
					'message' => 'Pessoa criada, mas não cadastrada no evento.'
				]);
			}
		}

		return $api->response([
			'success' => true,
			'message' => 'Pessoa criada',
			'person' => [
				'person_id' => $person->id,
				'person_type_id' => $person->person_type_id,
				'name' => $person->id,
				'email' => $person->email,
				'rg' => $person->rg,
				'cpf' => $person->cpf,
				'date_of_birth' => $person->date_of_birth,
				'phone' => $person->phone,
				'photo' => $person->photo,
				'team' => [
					'team_id' => $team->id,
					'name' => $team->name,
				],
			]
		]);
	}

	public function getPerson( $personId ) {
		$api = $this->api;

		$person = new PersonObject( (int) $personId );
		if(!Validate::isLoadedObject($person)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Person was not found'
			]);
		}
		
		$category = new CategoryObject( $person->category_id );

		return $api->response([
			'success' => true,
			'message' => 'Person was Created',
			'person' => [
				'person_id' => $person->id,
				'name' => $person->name,
				'description' => $person->description,
				'price' => (float) $person->price,
				'category' => [
					'category_id' => $category->id,
					'name' => $category->name,
					'description' => $category->description,
				],
			]
		]);
	}

	public function updatePerson($personId ) {
		$api = $this->api;
		$payload = $api->request()->post(); 

		$person = new PersonObject( (int) $personId );
		if(!Validate::isLoadedObject($person)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Person was not found'
			]);
		}

		if (ArrayUtils::has($payload, 'name')) {
			$name = ArrayUtils::get($payload, 'name');
			if ( !Validate::isGenericName($name) ) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid person name'
				]);
			}

			$person->name = $name;
		}

		if (ArrayUtils::has($payload, 'description')) {
			$description = ArrayUtils::get($payload, 'description');
			if (!Validate::isCleanHtml($description)) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid description of the person'
				]);
			}

			$person->description = $description;
		}

		if (ArrayUtils::has($payload, 'description')) {
			$price = ArrayUtils::get($payload, 'price');
			if (!Validate::isPrice($price)) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid price of the person'
				]);
			}

			$person->price = $price;
		}

		if (ArrayUtils::has($payload, 'category_id')) {
			$category_id = ArrayUtils::get($payload, 'category_id');
			if(!Validate::isInt($category_id)) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid category ID of the person'
				]);
			}

			$category = new CategoryObject( (int) $category_id );
			if (!Validate::isLoadedObject($category)) {
				return $api->response([
					'success' => false,
					'message' => 'The category ID (' . $category_id . ') does not exist'
				]);
			}

			$person->category_id = $category->id;
		}

		return $api->response([
			'success' => false,
			'message' => 'Unable to update person'
		]);

		$ok = $person->save();
		// or person->update()
		
		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to update person'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Person updated successfully'
		]);
	}

	public function deletePerson( $personId ) {
		$api = $this->api;

		$person = new PersonObject( (int) $personId );
		if(!Validate::isLoadedObject($person)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Person was not found'
			]);
		}

		$ok = $person->delete();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to delete person'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Person deleted successfully'
		]);
	}
	
	public function searchPersons() {
		$api = $this->api;
		$params = $api->request()->get(); 

		$name = ArrayUtils::get($params, 'name');
		$description = ArrayUtils::get($params, 'description');

		if(!$name && !$description) {
			return $api->response([
				'success' => false,
				'message' => 'Enter name or description of the person'
			]);
		}

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('person.*');
		// Build FROM
		$sql->from('person', 'person');

		// prperson sql from searching a NULL value if wither name or description is not provided eg. WHERE name = null
		$where_clause = array();
		if($name) {
			$where_clause[] = 'person.name LIKE \'%' . pSQL($name) . '%\'';
		}

		if ($description) {
			$where_clause[] = 'person.description LIKE \'%' . pSQL($description) . '%\'';
		}

		// join the search terms
		$where_clause = implode(' OR ', $where_clause);

		// Build WHERE
		$sql->where($where_clause);

		$persons = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'persons' => $persons
		]);
	}
}


