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
use RoboticEvent\Entities\Robot as RobotObject;
use RoboticEvent\Entities\Team as TeamObject;
use RoboticEvent\Entities\Category as CategoryObject;
use RoboticEvent\Util\ArrayUtils;
use RoboticEvent\Validate;

class Robot extends Route {

	public function getRobots() {
		$api = $this->api;

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('robot.*');
		// Build FROM
		$sql->from('robot', 'robot');
		$robots = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'robots' => $robots
		]);
	}

	public function getRobotsByTeamId( $teamId ) {
		$api = $this->api;

		$sql = new DbQuery();
		$sql->select('robot.*');
		$sql->from('robot');

		$sql->where('team_id = ' . pSQL($teamId));

		$robots = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'robots' => $robots
		]);
	}	

	public function getRobotsByEventId( $eventId ) {
		$api = $this->api;

		$sql = new DbQuery();
		$sql->select('robot.*');
		$sql->from('robot');
		$sql->from('event');
		$sql->from('event_robot');

		$sql->where('event_robot.robot_id = robot.robot_id');
		$sql->where('event_robot.event_id = event.event_id');
		$sql->where('event.event_id = ' . pSQL($eventId));

		$robots = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'robots' => $robots
		]);
	}

	public function addRobot() {
		$api = $this->api;
		$payload = $api->request()->post(); 

		
		$event_id = ArrayUtils::get($payload, 'event_id');
		$category_id = ArrayUtils::get($payload, 'category_id');

		$robot = new RobotObject();
		$robot->team_id = null;

		if (ArrayUtils::has($payload, 'name')) {
			$name = ArrayUtils::get($payload, 'name');
			if (!Validate::isGenericName($name)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um nome válido'
				]);
			}

			$robot->name = $name;
		}

		if (ArrayUtils::has($payload, 'photo')) {
			$phone = ArrayUtils::get($payload, 'photo');

			if (!Validate::isString($photo)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma string válida para o caminho da foto'
				]);
			}

			$robot->photo = $photo;
		}

		$team = null;
		$team_arr = array();

		if (ArrayUtils::has($payload, 'team_id')) {
			$team_id = ArrayUtils::get($payload, 'team_id');
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
			
			$robot->team_id = $team->id;

			$team_arr =	[
					'team_id' => $robot->team_id,
					'name' => $team->name,
			];
		} else {
			$robot->team_id = null;
		}

        $category = new CategoryObject( (int) $category_id );
        if (!Validate::isLoadedObject($category)) {
            return $api->response([
                'success' => false,
                'message' => 'O ID de categoria (' . $category_id . ') não existe.'
            ]);
        }

        $robot->category_id = $category->id;

		$ok = $robot->save(true);
		// or $robot->add();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Não foi possível criar o Robô'
			]);
		}

		if ($event_id != null) {
			if (!Db::getInstance()->insert('event_robot', array(
				'event_id' => $event_id,
				'robot_id' => $robot->id
			))) {
				return $api->response([
					'success' => false,
					'message' => 'Robô criado, mas não cadastrado no evento.'
				]);
			}
		}

		return $api->response([
			'success' => true,
			'message' => 'Robô criado',
			'robot' => [
				'robot_id' => $robot->id,
				'name' => $robot->name,
				'photo' => $robot->photo,
                'team' => $team_arr,
                'category' => [
                    'category_id' => $robot->category_id,
                    'name' => $category->name
                ]
			]
		]);
	}

	public function getRobot( $robotId ) {
		$api = $this->api;

		$robot = new RobotObject( (int) $robotId );
		if(!Validate::isLoadedObject($robot)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Pessoa não encontrada'
			]);
		}
		
		$team = new TeamObject( $robot->team_id );
		$team_arr = array();
		if (Validate::isLoadedObject($team)) {
			$team_arr =	[
				'team_id' => $team->id,
				'name' => $team->name,
			];
        }
        
        $category = new CategoryObject( (int) $robot->category_id );
        if (!Validate::isLoadedObject($category)) {
            return $api->response([
                'success' => false,
                'message' => 'O ID de categoria (' . $category_id . ') não existe.'
            ]);
        }

		return $api->response([
			'success' => true,
			'message' => 'Robô criado',
			'robot' => [
				'robot_id' => $robot->id,
				'name' => $robot->name,
				'photo' => $robot->photo,
                'team' => $team_arr,
                'category' => [
                    'category_id' => $robot->category_id,
                    'name' => $category->name
                ]
			]
		]);
	}

	public function updateRobot($robotId ) {
		$api = $this->api;
		$payload = $api->request()->post(); 

		$robot = new RobotObject( (int) $robotId );
		if(!Validate::isLoadedObject($robot)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Pessoa não encontrada'
			]);
		}

		if (ArrayUtils::has($payload, 'name')) {
			$name = ArrayUtils::get($payload, 'name');
			if (!Validate::isGenericName($name)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um nome válido'
				]);
			}

			$robot->name = $name;
		}

		if (ArrayUtils::has($payload, 'email')) {
			$email = ArrayUtils::get($payload, 'email');
			if (!Validate::isEmail($email)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um email válido'
				]);
			}

			$robot->email = $email;
		}
		
		if (ArrayUtils::has($payload, 'cpf')) {
			$cpf = ArrayUtils::get($payload, 'cpf');
			if (!Validate::isCpf($cpf)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um cpf válido'
				]);
			}

			$robot->cpf = $cpf;
		}

		if (ArrayUtils::has($payload, 'rg')) {
			$rg = ArrayUtils::get($payload, 'rg');
			if (!Validate::isRg($rg)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite um rg válido'
				]);
			}

			$robot->rg = $rg;
		}

		if (ArrayUtils::has($payload, 'rg')) {
			$date_of_birth = ArrayUtils::get($payload, 'date_of_birth');
			if (!Validate::isDate($date_of_birth)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma data de nascimento válida'
				]);
			}

			$robot->date_of_birth = $date_of_birth;
		}

		if (ArrayUtils::has($payload, 'phone')) {
			$phone = ArrayUtils::get($payload, 'phone');

			if (!Validate::isString($phone)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma string válida para o telefone'
				]);
			}

			$robot->phone = $phone;
		}

		if (ArrayUtils::has($payload, 'photo')) {
			$phone = ArrayUtils::get($payload, 'photo');

			if (!Validate::isString($photo)) {
				return $api->response([
					'success' => false,
					'message' => 'Digite uma string válida para o caminho da foto'
				]);
			}

			$robot->photo = $photo;
		}
		
		if (ArrayUtils::has($payload, 'robot_type_id')) {
			$phone = ArrayUtils::get($payload, 'robot_type_id');

			if (!Validate::isInt($robot_type_id)) {
				return $api->response([
					'success' => false,
					'message' => 'O tipo de pessoa deve ser um inteiro'
				]);
			}

			$robot->robot_type_id = $robot_type_id;
		}

		if (ArrayUtils::has($payload, 'team_id')) {
			$team_id = ArrayUtils::get($payload, 'team_id');
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
			
			$robot->team_id = $team->id;
		}


		$ok = $robot->save(true);
		// or robot->update()
		
		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Não foi possível atualizar a Pessoa'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Pessoa atualizada com sucesso',
			'team_id' => $robot->team_id
		]);
	}

	public function deleteRobot( $robotId ) {
		$api = $this->api;

		$robot = new RobotObject( (int) $robotId );
		if(!Validate::isLoadedObject($robot)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Robot was not found'
			]);
		}

		$ok = $robot->delete();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Unable to delete robot'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Robot deleted successfully'
		]);
	}
	
	public function searchRobots() {
		$api = $this->api;
		$params = $api->request()->get(); 

		$name = ArrayUtils::get($params, 'name');
		$description = ArrayUtils::get($params, 'description');

		if(!$name && !$description) {
			return $api->response([
				'success' => false,
				'message' => 'Enter name or description of the robot'
			]);
		}

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('robot.*');
		// Build FROM
		$sql->from('robot', 'robot');

		// prrobot sql from searching a NULL value if wither name or description is not provided eg. WHERE name = null
		$where_clause = array();
		if($name) {
			$where_clause[] = 'robot.name LIKE \'%' . pSQL($name) . '%\'';
		}

		if ($description) {
			$where_clause[] = 'robot.description LIKE \'%' . pSQL($description) . '%\'';
		}

		// join the search terms
		$where_clause = implode(' OR ', $where_clause);

		// Build WHERE
		$sql->where($where_clause);

		$robots = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'robots' => $robots
		]);
	}
}


