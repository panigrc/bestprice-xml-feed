<?php
/**
 * Created by PhpStorm.
 * User: vagenas
 * Date: 17/10/2014
 * Time: 11:30 πμ
 */

/**
 * Class SimpleXMLExtended extends SimpleXMLElement so CDATA con be added without enconding
 */
if(!class_exists('SimpleXMLExtended')){
	class SimpleXMLExtended extends SimpleXMLElement {
		public function addCData($cdata_text) {
			$node = dom_import_simplexml($this);
			$no   = $node->ownerDocument;
			$node->appendChild($no->createCDATASection($cdata_text));
		}
	}
}