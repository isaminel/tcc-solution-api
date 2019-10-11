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

class Following extends ObjectModel {
	/** @var $id Following ID */
	public $id;

	/** @var int $users_id */
	public $users_id;

	/** @var int $ideas_id */
	public $ideas_id;
	
	/** @var $date_add */
    public $date_add;
	
	/** @var $date_upd */
    public $date_upd;

	/**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'following',
        'primary' => 'id',
        'fields' => array(
			'users_id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'size' => 11),
			'ideas_id' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'size' => 11),
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