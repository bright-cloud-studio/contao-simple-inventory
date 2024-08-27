<?php

namespace Bcs\Backend;

use Contao\Backend;
use Contao\Image;
use Contao\Input;
use Bcs\Model\SimpleInventory;

class SimpleInventoryBackend extends Backend
{

    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }
        
        $href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);
        
        if (!$row['published'])
        {
            $icon = 'invisible.gif';
        }
        
        return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
    }

    public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
	{
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_simple_inventory']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_simple_inventory']['fields']['published']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, ($dc ?: $this));
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, ($dc ?: $this));
				}
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_simple_inventory SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);

		$this->log('A new version of record "tl_simple_inventory.id='.$intId.'" has been created'.$this->getParentEntries('tl_simple_inventory_tracker', $intId), __METHOD__, TL_GENERAL);
	}

    public function onReplaceTag (string $insertTag)
    {
        // if this tag doesnt contain :: it doesn't have an id, so we can stop right here
        if (stristr($insertTag, "::") === FALSE) {
            return 'no_id';
        }

        // break our tag into an array
        $arrTag = explode("::", $insertTag);

        // lets make decisions based on the beginning of the tag
        switch($arrTag[0]) {
            // if the tag is what we want, {{simple_inventory::id}}, then lets go
            case 'simple_inventory':
                // take our id, $arrTag[1], and pull our data out and return it
                $ourInfo = SimpleInventory::findOneBy('id', $arrTag[1]);
                // for now, lets just return our ID to show we can get here
                return $ourInfo->product_inventory;
            break;

            // if we want to have other tags do other things they would go here
        }

        // this is an example from Andy for how I can pull that data out
        // <Model_Name>::findBy('<field_name>', 'lookup_data');

        // something has gone horribly wrong, let the user know and hope for brighter lights ahead
        return 'something_went_wrong';
    }
    
}
