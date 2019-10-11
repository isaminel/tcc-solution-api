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
use TCCSolution\Entities\Category as CategoryObject;
use TCCSolution\Util\ArrayUtils;
use TCCSolution\Validate;

class Category extends Route {
	public function getCategory() {
		$api = $this->api;

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('category.*');
		// Build FROM
		$sql->from('category', 'category');
		$category = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'category' => $category
		]);
	}

	public function addCategory() {
		$api = $this->api;
		$payload = $api->request()->post(); 

		$name = ArrayUtils::get($payload, 'name');

		if (!Validate::isName($name)) {
			return $api->response([
				'success' => false,
				'message' => 'Digite um nome válido para a categoria'
			]);
		}

		$category = new CategoryObject();
		$category->name = $name;

		$ok = $category->save();
		// or $category->add();

		if (!$ok) {
			return $api->response([
				'success' => false,
				'message' => 'Não foi possível criar a categoria'
			]);
		}

		return $api->response([
			'success' => true,
			'message' => 'Categoria criada com sucesso',
			'category' => [
				'id' => $category->id,
				'name' => $category->name,
			]
		]);
	}

}