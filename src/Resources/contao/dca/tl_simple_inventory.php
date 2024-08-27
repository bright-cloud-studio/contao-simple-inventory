<?php

use Contao\DC_Table;

/** Table tl_simple_inventory_tracker */
$GLOBALS['TL_DCA']['tl_simple_inventory'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'               => DC_Table::class,
        'enableVersioning'            => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' 	=> 	'primary',
                'product_name' =>  'index'
            )
        )
    ),
 
    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 0,
            'panelLayout'             => 'filter;search,limit'
        ),
        'label' => array
        (
            'fields'                  => array('product_name', 'product_inventory'),
            'format'                  => '%s <span style="font-weight: bold;">(%s)</span>'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_simple_inventory']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
			
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_simple_inventory']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_simple_inventory']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_simple_inventory']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('Bcs\Backend\SimpleInventory', 'toggleIcon')
			),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_simple_inventory']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),
 
    // Palettes
    'palettes' => array
    (
        'default'                     => '{product_legend},product_name,product_inventory;{publish_legend},published;'
    ),
 
    // Fields
    'fields' => array
    (
        'id' => array
        (
		    'sql'                     	=> "int(10) unsigned NOT NULL auto_increment"
        ),
            'tstamp' => array
        (
		    'sql'                     	=> "int(10) unsigned NOT NULL default 0"
        ),
    	'sorting' => array
    	(
    		'sql'                    	=> "int(10) unsigned NOT NULL default '0'"
    	),
    	'product_name' => array
    	(
    		'label'                   => &$GLOBALS['TL_LANG']['tl_simple_inventory']['product_name'],
    		'inputType'               => 'text',
    		'default'                 => '',
    		'search'                  => true,
    		'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    		'sql'                     => "varchar(255) NOT NULL default ''"
    	),
    	'product_inventory' => array
    	(
    		'label'                   => &$GLOBALS['TL_LANG']['tl_simple_inventory']['product_inventory'],
    		'inputType'               => 'text',
    		'default'                 => '0',
    		'search'                  => true,
    		'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
    		'sql'                     => "int(10) unsigned NOT NULL default ''"
    	),
    	'published' => array
    	(
    		'exclude'                 => true,
    		'label'                   => &$GLOBALS['TL_LANG']['tl_simple_inventory']['published'],
    		'inputType'               => 'checkbox',
    		'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true),
    		'sql'                     => "char(1) NOT NULL default ''"
    	)		
    )
);
