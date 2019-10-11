<?php
/**
 * @package    PHP Advanced API Guide
 * @author     Isabelle Minel <isabelleminel@gmail.com>
 * @copyright  2019 TCCSolution
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

namespace TCCSolution\v1;

use Db;
use TCCSolution\Route;
use TCCSolution\Database\DbQuery;
use TCCSolution\Entities\User as UserObject;
use TCCSolution\Util\ArrayUtils;
use TCCSolution\Validate;

class User extends Route {
	public function getUser() {
		$api = $this->api;

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('user.*');
		// Build FROM
		$sql->from('user', 'user');
		$user = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'user' => $user
		]);
	}

	public function addUser() {
		$api = $this->api;
		$payload = $api->request()->post(); 

		$name = ArrayUtils::get($payload, 'name');
		$email = ArrayUtils::get($payload, 'email');
		$date_of_birth = ArrayUtils::get($payload, 'date_of_birth');
		$login = ArrayUtils::get($payload, 'login');
		$password = ArrayUtils::get($payload, 'password');

		if (!Validate::isName($name)) {
			return $api->response([
				'success' => false,
				'message' => 'Digite um nome válido para o usuário'
			]);
		}

		if (!Validate::isEmail($email)) {
			return $api->response([
				'success' => false,
				'message' => 'Digite um e-mail válido para o usuário'
			]);
		}

		if (!Validate::isDateFormat($date_of_birth)) {
			return $api->response([
				'success' => false,
				'message' => 'Digite uma data válida para o usuário'
			]);
		}

		/*if (!Validate::isCatalogLogin($login)) {
			return $api->response([
				'success' => false,
				'message' => 'Digite um login válido para o usuário'
			]);
		}

		if (!Validate::isCatalogPassword($password)) {
			return $api->response([
				'success' => false,
				'message' => 'Digite uma senha válida para o usuário'
			]);
		}*/

		$user = new UserObject();
		$user->name = $name;
		$user->email = $email;
		$user->date_of_birth = $date_of_birth;
		$user->login = $login;
		$user->password = $password;

		$ok = $user->save();
		// or $user->add();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Não foi possível criar o usuário'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Usário criado com sucesso',
			'user' => [
				'id' => $user->id,
				'name' => $user->name,
				'email' => $user->email,
				'date_of_birth' => $user->date_of_birth,
				'login' => $user->login,
				'password' => $user->password,
			]
		]);
	}

}