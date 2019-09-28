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
use RoboticEvent\Product\Category as CategoryObject;
use RoboticEvent\Util\ArrayUtils;
use RoboticEvent\Validate;

class Category extends Route {
	public function getCategories() {
		$api = $this->api;

		// Build query
		$sql = new DbQuery();
		// Build SELECT
		$sql->select('category.*');
		// Build FROM
		$sql->from('category', 'category');
		$categories = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'categories' => $categories
		]);
	}

	public function getCategoriesByEventId( $eventId ) {
		$api = $this->api;

		$sql = new DbQuery();
		$sql->select('category.*');
		$sql->from('category');
		$sql->from('event');
		$sql->from('event_category');

		$sql->where('event_category.category_id = category.category_id');
		$sql->where('event_category.event_id = event.event_id');
		$sql->where('event.event_id = ' . pSQL($eventId));

		$categories = Db::getInstance()->executeS($sql);

		return $api->response([
			'success' => true,
			'categories' => $categories
		]);
	}

	public function addCategory() {
		$api = $this->api;
		$payload = $api->request()->post(); 

		$name = ArrayUtils::get($payload, 'name');
		$description = ArrayUtils::get($payload, 'description');

		if (!Validate::isCatalogName($name)) {
			return $api->response([
				'success' => false,
				'message' => 'Digite um nome válido para a categoria'
			]);
		}

		if (!Validate::isCleanHtml($description)) {
			return $api->response([
				'success' => false,
				'message' => 'Digite uma descrição para a categoria'
			]);
		}

		$category = new CategoryObject();
		$category->name = $name;
		$category->description = $description;

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
				'category_id' => $category->id,
				'name' => $category->name,
				'description' => $category->description,
			]
		]);
	}

}