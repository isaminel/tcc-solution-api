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
use RoboticEvent\Entities\Team as TeamObject;
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

		$team = new TeamObject();

		if (ArrayUtils::has($payload, 'name')) {
			$name = ArrayUtils::get($payload, 'name');
			if ( !Validate::isGenericName($name) ) {
				return $api->response([
					'success' => false,
					'message' => 'Entre um nome válido para a equipe'
				]);
			}

			$team->name = $name;
		}

		if (ArrayUtils::has($payload, 'email')) {
			$email = ArrayUtils::get($payload, 'email');
			if (!Validate::isEmail($email)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um email válido'
				]);
			}

			$team->email = $email;
		}

		if (ArrayUtils::has($payload, 'website')) {
			$website = ArrayUtils::get($payload, 'website');
			if (!Validate::isUrl($website)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma URL válida para o website'
				]);
			}

			$team->website = $website;
		}

		if (ArrayUtils::has($payload, 'slogan')) {
			$slogan = ArrayUtils::get($payload, 'slogan');
			if(!Validate::isString($slogan)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma string válida para o slagan'
				]);
			}

			$team->slogan = $slogan;
		}

		if (ArrayUtils::has($payload, 'institution')) {
			$institution = ArrayUtils::get($payload, 'institution');
			if ( !Validate::isGenericName($institution) ) {
				return $api->response([
					'success' => false,
					'message' => 'Entre um nome válido para a instituição'
				]);
			}

			$team->institution = $institution;
		}

		if (ArrayUtils::has($payload, 'country')) {
			$country = ArrayUtils::get($payload, 'country');
			if ( !Validate::isGenericName($country) ) {
				return $api->response([
					'success' => false,
					'message' => 'Entre um nome válido para o país'
				]);
			}

			$team->country = $country;
		}

		if (ArrayUtils::has($payload, 'state')) {
			$state = ArrayUtils::get($payload, 'state');
			if ( !Validate::isGenericName($state) ) {
				return $api->response([
					'success' => false,
					'message' => 'Entre um nome válido para o estado'
				]);
			}

			$team->state = $state;
		}

		if (ArrayUtils::has($payload, 'city')) {
			$city = ArrayUtils::get($payload, 'city');
			if ( !Validate::isGenericName($city) ) {
				return $api->response([
					'success' => false,
					'message' => 'Entre um nome válido para a cidade'
				]);
			}

			$team->city = $city;
		}

		if (ArrayUtils::has($payload, 'image')) {
			$image = ArrayUtils::get($payload, 'image');
			if ( !Validate::isString($institution) ) {
				return $api->response([
					'success' => false,
					'message' => 'Entre uma string válida para o caminho da imagem'
				]);
			}

			$team->image = $image;
		}

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
				'institution' => $team->institution,
				'slogan' => $team->slogan,
				'city' => $team->city,
				'state' => $team->state,
				'country' => $team->country,
				'image' => $team->image,
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
				'message' => 'Equipe encontrada'
			]);
		}
		
		$team = new TeamObject( $team->id );

		return $api->response([
			'success' => true,
			'message' => 'Equipe encontrada',
			'team' => [
				'team_id' => $team->id,
				'name' => $team->name,
				'email' => $team->email,
				'website' => $team->website,
				'institution' => $team->institution,
				'slogan' => $team->slogan,
				'city' => $team->city,
				'state' => $team->state,
				'country' => $team->country,
				'image' => $team->image,
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
				'message' => 'A equipe não foi encontrada'
			]);
		}

		if (ArrayUtils::has($payload, 'name')) {
			$name = ArrayUtils::get($payload, 'name');
			if ( !Validate::isGenericName($name) ) {
				return $api->response([
					'success' => false,
					'message' => 'Entre um nome válido para a equipe'
				]);
			}

			$team->name = $name;
		}

		if (ArrayUtils::has($payload, 'email')) {
			$email = ArrayUtils::get($payload, 'email');
			if (!Validate::isEmail($email)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um email válido'
				]);
			}

			$team->email = $email;
		}

		if (ArrayUtils::has($payload, 'website')) {
			$website = ArrayUtils::get($payload, 'website');
			if (!Validate::isUrl($website)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma URL válida para o website'
				]);
			}

			$team->website = $website;
		}

		if (ArrayUtils::has($payload, 'slogan')) {
			$slogan = ArrayUtils::get($payload, 'slogan');
			if(!Validate::isString($slogan)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma string válida para o slagan'
				]);
			}

			$team->slogan = $slogan;
		}

		if (ArrayUtils::has($payload, 'institution')) {
			$institution = ArrayUtils::get($payload, 'institution');
			if ( !Validate::isGenericName($institution) ) {
				return $api->response([
					'success' => false,
					'message' => 'Entre um nome válido para a instituição'
				]);
			}

			$team->institution = $institution;
		}

		if (ArrayUtils::has($payload, 'country')) {
			$country = ArrayUtils::get($payload, 'country');
			if ( !Validate::isGenericName($country) ) {
				return $api->response([
					'success' => false,
					'message' => 'Entre um nome válido para o país'
				]);
			}

			$team->country = $country;
		}

		if (ArrayUtils::has($payload, 'state')) {
			$state = ArrayUtils::get($payload, 'state');
			if ( !Validate::isGenericName($state) ) {
				return $api->response([
					'success' => false,
					'message' => 'Entre um nome válido para o estado'
				]);
			}

			$team->state = $state;
		}

		if (ArrayUtils::has($payload, 'city')) {
			$city = ArrayUtils::get($payload, 'city');
			if ( !Validate::isGenericName($city) ) {
				return $api->response([
					'success' => false,
					'message' => 'Entre um nome válido para a cidade'
				]);
			}

			$team->city = $city;
		}

		if (ArrayUtils::has($payload, 'image')) {
			$image = ArrayUtils::get($payload, 'image');
			if ( !Validate::isString($institution) ) {
				return $api->response([
					'success' => false,
					'message' => 'Entre uma string válida para o caminho da imagem'
				]);
			}

			$team->image = $image;
		}

		$ok = $team->save();
		// or team->update()
		
		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Não foi possível atualizar a equipe'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Equipe atualizada com sucesso'
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


