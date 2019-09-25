<?php 
/**
 * @package    RoboticEvent
 * @author     Davison Pro <davisonpro.coder@gmail.com>
 * @copyright  2018 RoboticEvent
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

namespace RoboticEvent\Person;

use Db;
use RoboticEvent\Database\DbQuery;
use RoboticEvent\ObjectModel;

class Robot extends ObjectModel {
	/** @var $id Robot ID */
	public $id;
	
	/** @var string $name */
    public $name;
    
    /** @var string $photo */
    public $photo;

	/** @var int $category_id */
	public $category_id;

	/** @var int $team_id */
	public $team_id;
	
	/** @var $date_add */
    public $date_add;
	
	/** @var $date_upd */
    public $date_upd;

	/**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'robot',
        'primary' => 'robot_id',
        'fields' => array(
            'team_id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'size' => 11),
            'category_id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'size' => 11),
			'name' => array('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isString', 'size' => 255),
            'photo' => array('type' => self::TYPE_STRING, 'required' => false),
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