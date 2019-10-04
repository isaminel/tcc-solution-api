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
use RoboticEvent\Entities\Person as PersonObject;
use RoboticEvent\Entities\Team as TeamObject;
use RoboticEvent\Entities\Robot as RobotObject;
use RoboticEvent\Util\ArrayUtils;
use RoboticEvent\Validate;


class Asaas extends Route {

    public function addClient( $personId ) {
        $api = $this->api;

        if (!$api) {
            die("bugou");
        }

		$person = new PersonObject( (int) $personId );
		if(!Validate::isLoadedObject($person)) {
			$api->response->setStatus(404);
			return $api->response([
				'success' => false,
				'message' => 'Pessoa não encontrada'
			]);
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $_ENV['BILLING_URL'] . "/customers");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
          \"name\": \"$person->name\",
          \"email\": \"$person->email\",
          \"phone\": \"$person->phone\",
          \"cpfCnpj\": \"$person->cpf\",
          \"externalReference\": \"$person->id\",
          \"notificationDisabled\": false
        }");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type: application/json",
          "access_token: " . $_ENV['BILLING_TOKEN']
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response == "200") {
			$api->response->setStatus(500);
            return $api->response([
				'success' => false,
				'message' => 'Não foi possível adicionar o cliente ao ASAAS'
			]);
        }

		$api->response->setStatus(200);
        return $api->response([
			'success' => true,
			'message' => 'Cliente criado no ASAAS'
		]);

    }
}

