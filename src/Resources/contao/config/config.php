<?php

/* Back end modules */
$GLOBALS['BE_MOD']['content']['simple_inventory'] = array(
	'tables' => array('tl_simple_inventory')
);

/* Hooks */
$GLOBALS['TL_HOOKS']['replaceInsertTags'][]        = array('Bcs\Backend\SimpleInventoryBackend', 'onReplaceTag');

/* Models */
$GLOBALS['TL_MODELS']['tl_simple_inventory']       = 'Bcs\Model\SimpleInventory';
