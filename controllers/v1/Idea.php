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
	public function getIdeas() {
		$api = $this->api;

		$payload = $api->request()->get();

		if (ArrayUtils::has($payload, 'title')) {
			$title = ArrayUtils::get($payload, 'title');
			$sql->where('title LIKE "%' . pSQL($title) . '%"');
		}

		if (ArrayUtils::has($payload, 'category')) {
			$category = ArrayUtils::get($payload, 'category');
			$sql->from('category');
			$sql->where('category.name LIKE "%' . pSQL($category) . '%"');
			$sql->where('category.id = idea.category_id');
		}

		if (ArrayUtils::has($payload, 'user')) {
			$user = ArrayUtils::get($payload, 'user');
			$sql->from('user');
			$sql->where('user.name LIKE "%' . pSQL($user) . '%"');
			$sql->where('user.id = idea.user_id');
		}

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
		error_log("alooooo");
		$api = $this->api;
		$payload = $api->request()->post(); 
		error_log(print_r($payload,1));
		if (ArrayUtils::has($payload, 'title')) {
			$title = ArrayUtils::get($payload, 'title');
		} else {
			return $api->response([
				'success' => false,
				'message' => 'Título não pode ser nulo'
			]);
		}
		
		$description = ArrayUtils::get($payload, 'description');
		$category_id = ArrayUtils::get($payload, 'category_id');
		$user_id = ArrayUtils::get($payload, 'user_id');

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
				'message' => 'Não foi possível criar a ideia',
				'title' => ArrayUtils::get($payload, 'title'),
				'description' => $description,
				'category_id' => $category_id,
				'user_id' => $user_id,
				'payload' => $payload
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