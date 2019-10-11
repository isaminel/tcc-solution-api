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
use TCCSolution\Entities\Idea as IdeaObject;
use TCCSolution\Util\ArrayUtils;
use TCCSolution\Validate;

class Idea extends Route {
	public function getIdea() {
		$api = $this->api;

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('idea.*');
		// Build FROM
		$sql->from('idea', 'idea');
		$idea = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'idea' => $idea
		]);
	}

	public function addIdea() {
		$api = $this->api;
		$payload = $api->request()->post(); 

		$name = ArrayUtils::get($payload, 'name');
		$email = ArrayUtils::get($payload, 'email');
		$date_of_birth = ArrayUtils::get($payload, 'date_of_birth');
		$login = ArrayUtils::get($payload, 'login');
		$password = ArrayUtils::get($payload, 'password');

		$idea = new IdeaObject();
		$idea->title = $title;
		$idea->description = $description;
		$idea->category_id = $category_id;
		$idea->user_id = $user_id;

		$ok = $idea->save();
		// or $idea->add();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Não foi possível criar a ideia'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Ideia criada com sucesso',
			'idea' => [
				'id' => $idea->id,
				'title' => $idea->title,
				'description' => $idea->description,
				'category_id' => $idea->category_id,
				'user_id' => $idea->user_id,
			]
		]);
	}

}