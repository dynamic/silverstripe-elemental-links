<?php

namespace Dynamic\Elements\Links\Extensions;

use Dynamic\Elements\Links\Elements\LinksElement;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\ORM\DataExtension;

/**
 * Class LinkDataExtension
 * @package Dynamic\Elements\Links\Extensions
 */
class LinkDataExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $db = [
        'ElementLinksSort' => 'Int',
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'LinksElement' => LinksElement::class,
    ];

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        if (($linksElement = $this->owner->LinksElementID) && $linksElement > 0) {
            $fields->replaceField(
                'LinksElementID',
                HiddenField::create('LinksElementID')
                    ->setValue($linksElement)
            );
        } else {
            $fields->removeByName('LinksElementID');
        }
    }
}
