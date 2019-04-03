<?php
/**
 * faadapter plugin for Craft CMS 3.x
 *
 * A plugin to get form assembly forms into templates.
 *
 * @link      eskargeaux.co
 * @copyright Copyright (c) 2019 Spencer Karges
 */

namespace skarges3\faadapter\variables;

use skarges3\faadapter\Faadapter;

use Craft;

/**
 * @author    Spencer Karges
 * @package   Faadapter
 * @since     1.0.0
 */
class FaadapterVariable
{
	public function get($options)
	{
		$formId = $options['formId'];

		$params = '';
		if( strlen($options['parameters']) > 0 ){
			$parameters = explode('|', $options['parameters']);

			for( $i = 0; $i < count($parameters); $i++ ) {
				$params .= $parameters[$i] . '=' . Craft::$app->request->getParam($parameters[$i]);
				if( $i < (count($parameters)-1) ) {
					$params .= '&';
				}
			}
		}

		$context = stream_context_create(array('http' => array('ignore_errors' => true)));
		if(!isset($_GET['tfa_next'])) {
			
			/* 
				Commented out to allow for multiple URL Params from Craft
				
				echo file_get_contents('https://app.formassembly.com/rest/forms/view/' . $formId .'?' . $eventIdField . '=' . $salesforceEventId,false,$context);
			*/

			echo file_get_contents('https://app.formassembly.com/rest/forms/view/' . $formId .'?' . $params,false,$context);
		} else {
			echo file_get_contents('https://app.formassembly.com/rest'.$_GET['tfa_next'],false,$context);
		}
	}

	function file_get_contents_curl($url) {
	    $ch = curl_init();

	    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

	    $data = curl_exec($ch);
	    curl_close($ch);

	    return $data;
	}
}
