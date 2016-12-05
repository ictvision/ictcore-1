<?php
/* * ***************************************************************
 * Copyright © 2015 ICT Innovations Pakistan All Rights Reserved   *
 * Developed By: Nasir Iqbal                                       *
 * Website : http://www.ictinnovations.com/                        *
 * Mail : nasir@ictinnovations.com                                 *
 * *************************************************************** */

class Fax extends Service
{

  /** @const */
  const SERVICE_FLAG = 2;
  const SERVICE_TYPE = 'fax';
  const CONTACT_FIELD = 'phone';
  const MESSAGE_CLASS = 'Document';
  const GATEWAY_CLASS = 'Freeswitch';
  
  public static function capabilities()
  {
    $capabilities = array();
    $capabilities['application'] = array(
        'inbound',
        'originate',
        'connect',
        'disconnect',
        'fax_receive',
        'fax_send',
        'log'
    );
    $capabilities['account'] = array(
        'extension',
        'did'
    );
    $capabilities['provider'] = array(
        'sip'
    );
    return $capabilities;
  }

  public function config_template($type, $name = '')
  {
    switch ($type) {
      case 'did':
        return 'account/did/freeswitch/default.twig';
      case 'extension':
        return 'account/extension/freeswitch/default.twig';
      case 'sip':
        return 'provider/sip/freeswitch/default.twig';
      default:
        return 'invalid.twig';
    }
  }

  public function application_template($application_name)
  {
    $gateway_class = static::GATEWAY_CLASS;
    $gateway_type = $gateway_class::GATEWAY_TYPE;
    switch ($application_name) {
      case 'originate':
        return "application/originate/$gateway_type/fax/default.json";
      case 'inbound':
      case 'connect':
      case 'disconnect':
      case 'fax_send':
      case 'fax_receive':
      case 'log':
        return "application/$application_name/$gateway_type/default.json";
    }
  }

}