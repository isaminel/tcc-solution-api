<?php 
/**
 * @package    TCCSolution
 * @author     Isabelle Minel <isabelleminel@gmail.com>
 * @copyright  2019 TCCSolution
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

namespace TCCSolution\Entities;

use Db;
use TCCSolution\Database\DbQuery;
use TCCSolution\ObjectModel;

class Idea extends ObjectModel {
	/** @var $id Idea ID */
	public $id;

	/** @var string $title */
	public $title;

	/** @var string $description */
    public $description;
    
    /** @var string $category_id */
    public $category_id;
    
    /** @var string $user_id */
	public $user_id;
	
	/** @var $date_add */
    public $date_add;
	
	/** @var $date_upd */
    public $date_upd;

	/**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'idea',
        'primary' => 'id',
        'fields' => array(
            'title' => array('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isString', 'size' => 255),
            'description' => array('type' => self::TYPE_STRING, 'required' => true),
            'category_id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'size' => 11),
            'user_id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'size' => 11),
			'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
			'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        )
    );

     /**
     * constructor.
     *
     * @param null $id
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
	}
}