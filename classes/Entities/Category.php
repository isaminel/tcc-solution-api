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

class Category extends ObjectModel {
	/** @var $id Category ID */
	public $id;

	/** @var string $name */
	public $name;
	
	/** @var $date_add */
    public $date_add;
	
	/** @var $date_upd */
    public $date_upd;

	/**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'category',
        'primary' => 'id',
        'fields' => array(
			'name' => array('type' => self::TYPE_STRING, 'required' => true),
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