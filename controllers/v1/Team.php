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
use RoboticEvent\Team\Team as TeamObject;
use RoboticEvent\Util\ArrayUtils;
use RoboticEvent\Validate;

class Team extends Route {

	public function getTeams() {
		$api = $this->api;

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('team.*');
		// Build FROM
		$sql->from('team', 'team');
		$teams = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'teams' => $teams
		]);
	}

	public function addTeam() {
		$api = $this->api;
		$payload = $api->request()->post(); 

		$name = ArrayUtils::get($payload, 'name');
		$email = ArrayUtils::get($payload, 'email');
		$website = ArrayUtils::get($payload, 'website');
		$slogan = ArrayUtils::get($payload, 'slogan');
		$institution = ArrayUtils::get($payload, 'institution');
		$country = ArrayUtils::get($payload, 'country');
		$state = ArrayUtils::get($payload, 'state');
		$city = ArrayUtils::get($payload, 'city');
		$image = ArrayUtils::get($payload, 'image');


		if (!Validate::isGenericName($name)) {
			return $api->response([
				'success' => false,
				'message' => 'Digite um nome válido'
			]);
		}

		if (!Validate::isEmail($email)) {
			return $api->response([
				'success' => false,
				'message' => 'Digite um email válido'
			]);
		}

		$team = new TeamObject();
		$team->name = $name;
		$team->email = $email;
		$team->website = $website;
		$team->slogan = $slogan;
		$team->institution = $institution;
		$team->country = $country;
		$team->state = $state;
		$team->city = $city;
		$team->image = $image;
		$team->date_add = date('Y-m-d H:m:s', time());

		$ok = $team->save();
		// or $team->add();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Não foi possível criar a Equipe'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Equipe criada',
			'team' => [
				'team_id' => $team->id,
				'name' => $team->name,
				'email' => $team->email,
				'website' => $team->website,
				'cpf' => $team->cpf,
				'date_of_birth' => $team->date_of_birth,
				'phone' => $team->phone,
				'photo' => $team->photo,
				'team' => [
					'team_id' => $team->id,
					'name' => $team->name,
				],
			]
		]);
	}

	public function getTeam( $teamId ) {
		$api = $this->api;

		$team = new TeamObject( (int) $teamId );
		if(!Validate::isLoadedObject($team)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Team was not found'
			]);
		}
		
		$category = new CategoryObject( $team->category_id );

		return $api->response([
			'success' => true,
			'message' => 'Team was Created',
			'team' => [
				'team_id' => $team->id,
				'name' => $team->name,
				'description' => $team->description,
				'price' => (float) $team->price,
				'category' => [
					'category_id' => $category->id,
					'name' => $category->name,
					'description' => $category->description,
				],
			]
		]);
	}

	public function updateTeam($teamId ) {
		$api = $this->api;
		$payload = $api->request()->post(); 

		$team = new TeamObject( (int) $teamId );
		if(!Validate::isLoadedObject($team)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Team was not found'
			]);
		}

		if (ArrayUtils::has($payload, 'name')) {
			$name = ArrayUtils::get($payload, 'name');
			if ( !Validate::isGenericName($name) ) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid team name'
				]);
			}

			$team->name = $name;
		}

		if (ArrayUtils::has($payload, 'description')) {
			$description = ArrayUtils::get($payload, 'description');
			if (!Validate::isCleanHtml($description)) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid description of the team'
				]);
			}

			$team->description = $description;
		}

		if (ArrayUtils::has($payload, 'description')) {
			$price = ArrayUtils::get($payload, 'price');
			if (!Validate::isPrice($price)) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid price of the team'
				]);
			}

			$team->price = $price;
		}

		if (ArrayUtils::has($payload, 'category_id')) {
			$category_id = ArrayUtils::get($payload, 'category_id');
			if(!Validate::isInt($category_id)) {
				return $api->response([
					'success' => false,
					'message' => 'Enter a valid category ID of the team'
				]);
			}

			$category = new CategoryObject( (int) $category_id );
			if (!Validate::isLoadedObject($category)) {
				return $api->response([
					'success' => false,
					'message' => 'The category ID (' . $category_id . ') does not exist'
				]);
			}

			$team->category_id = $category->id;
		}

		return $api->response([
			'success' => false,
			'message' => 'Unable to update team'
		]);

		$ok = $team->save();
		// or team->update()
		
		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to update team'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Team updated successfully'
		]);
	}

	public function deleteTeam( $teamId ) {
		$api = $this->api;

		$team = new TeamObject( (int) $teamId );
		if(!Validate::isLoadedObject($team)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Team was not found'
			]);
		}

		$ok = $team->delete();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to delete team'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Team deleted successfully'
		]);
	}
	
	public function searchTeams() {
		$api = $this->api;
		$params = $api->request()->get(); 

		$name = ArrayUtils::get($params, 'name');
		$description = ArrayUtils::get($params, 'description');

		if(!$name && !$description) {
			return $api->response([
				'success' => false,
				'message' => 'Enter name or description of the team'
			]);
		}

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('team.*');
		// Build FROM
		$sql->from('team', 'team');

		// prteam sql from searching a NULL value if wither name or description is not provided eg. WHERE name = null
		$where_clause = array();
		if($name) {
			$where_clause[] = 'team.name LIKE \'%' . pSQL($name) . '%\'';
		}

		if ($description) {
			$where_clause[] = 'team.description LIKE \'%' . pSQL($description) . '%\'';
		}

		// join the search terms
		$where_clause = implode(' OR ', $where_clause);

		// Build WHERE
		$sql->where($where_clause);

		$teams = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'teams' => $teams
		]);
	}
}


