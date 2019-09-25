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

class Event extends ObjectModel {
	/** @var $id Event ID */
	public $id;
	
	/** @var string $name */
	public $name;

	/** @var string $email */
	public $email;

	/** @var string $website */
	public $website;

	/** @var string $address */
	public $address;

	/** @var $date_start */
    public $date_start;

	/** @var $date_end */
	public $date_end;

    /** @var string $country */
    public $country;

    /** @var string $state */
    public $state;

    /** @var string $city */
    public $city;
    
    /** @var string $image */
    public $image;

	/** @var $date_add */
    public $date_add;
	
	/** @var $date_upd */
    public $date_upd;

	/**
     * @see ObjectModel::$definition
     */
    public static $definition = array(
        'table' => 'event',
        'primary' => 'event_id',
        'fields' => array(
			'name' => array('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isString', 'size' => 255),
			'email' => array('type' => self::TYPE_STRING, 'required' => true, 'validate' => 'isString'),
            'website' => array('type' => self::TYPE_STRING, 'required' => false, 'validate' => 'isString'),
            'slogan' => array('type' => self::TYPE_STRING, 'required' => false, 'validate' => 'isString'),
            'institution' => array('type' => self::TYPE_STRING, 'required' => false, 'validate' => 'isString'),
            'country' => array('type' => self::TYPE_STRING, 'required' => false, 'validate' => 'isString'),
            'state' => array('type' => self::TYPE_STRING, 'required' => false, 'validate' => 'isString'),
            'city' => array('type' => self::TYPE_STRING, 'required' => false, 'validate' => 'isString'),
            'image' => array('type' => self::TYPE_STRING, 'required' => false),
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