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

class User extends ObjectModel {
	/** @var $id User ID */
	public $id;

	/** @var int $name */
	public $name;

	/** @var int $email */
	public $email;
	
	/** @var string $date_of_birth */
	public $date_of_birth;

	/** @var string $login */
	public $login;

	/** @var string $password */
	public $password;
	
	/** @var $date_add */
    public $date_add;
	
	/** @var $date_upd */
    public $date_upd;

	/**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'user',
        'primary' => 'id',
        'fields' => array(
			'name' => array	('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isString', 'size' => 255),
			'email' => array('type' => self::TYPE_STRING, 'required' => true),
			'date_of_birth' => array('type' => self::TYPE_DATE, 'required' => true),
			'login' => array('type' => self::TYPE_STRING, 'required' => true),
			'password' => array('type' => self::TYPE_STRING, 'required' => true),
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