<?php 
/**
 * @package    RoboticEvent
 * @author     Davison Pro <davisonpro.coder@gmail.com>
 * @copyright  2018 RoboticEvent
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

namespace RoboticEvent\Entities;

use Db;
use RoboticEvent\Database\DbQuery;
use RoboticEvent\ObjectModel;

class Person extends ObjectModel {
	/** @var $id Person ID */
	public $id;

	/** @var int $team_id */
	public $team_id;

	/** @var int $person_type_id */
	public $person_type_id;
	
	/** @var string $name */
	public $name;

	/** @var string $email */
	public $email;

	/** @var string $rg */
	public $rg;

	/** @var string $cpf */
	public $cpf;

	/** @var $date_of_birth */
	public $date_of_birth;

	/** @var string $phone */
	public $phone;

	/** @var string $photo */
    public $photo;
	
	/** @var $date_add */
    public $date_add;
	
	/** @var $date_upd */
    public $date_upd;

	/**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'person',
        'primary' => 'person_id',
        'fields' => array(
			'team_id' => array('type' => self::TYPE_INT, 'required' => false, 'validate' => 'isInt', 'size' => 11, 'allow_null' => true),
			'person_type_id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'size' => 11),
			'name' => array('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isString', 'size' => 255),
			'email' => array('type' => self::TYPE_STRING, 'required' => true),
			'rg' => array('type' => self::TYPE_STRING, 'required' => true),
			'cpf' => array('type' => self::TYPE_STRING, 'required' => true),
			'date_of_birth' => array('type' => self::TYPE_DATE, 'required' => true),
			'phone' => array('type' => self::TYPE_STRING, 'required' => false),
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