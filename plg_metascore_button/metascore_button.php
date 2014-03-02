<?php
/**
* @version		$Id: metascore_button.php $
* @package		Daily Fidelity
* @copyright	Copyright (C) 2008 - 2012 Daily Fidelity, LLC. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Editor Metascore buton
 *
 * @package Editors-xtd
 * @since 1.5
 */
class plgButtonmetascore_button extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @param 	array  $config  An array that holds the plugin configuration
	 * @since 1.5
	 */
	function plgButtonmetascore_button(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	/**
	 * @return array A two element array of ( imageName, textToInsert )
	 */
	function onDisplay($name)
	{
		global $mainframe;

		$doc 		=& JFactory::getDocument();
		$template 	= $mainframe->getTemplate();

		// button is not active in specific content components

		$getContent = $this->_subject->getContent($name);
		$present = JText::_('There is already an metascore tag in this article', true) ;
		$js = "
			function insertmetascore(editor) {
				var content = $getContent
				if (content.match(/{metascore url=}/i)) {
					alert('$present');
					return false;
				} else {
					jInsertEditorText(\"{metascore url=http://www.metacritic.com/pasterestofurlhere/}\", editor);
				}
			}
			";

		$doc->addScriptDeclaration($js);

		$button = new JObject();
		$button->set('modal', false);
		$button->set('onclick', 'insertmetascore(\''.$name.'\');return false;');
		$button->set('text', JText::_('metascore'));
		$button->set('name', 'readmore');
		// TODO: The button writer needs to take into account the javascript directive
		//$button->set('link', 'javascript:void(0)');
		$button->set('link', '#');

		return $button;
	}
}