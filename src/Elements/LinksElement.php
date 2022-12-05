<?php

namespace Dynamic\Elements\Links\Elements;

use DNADesign\Elemental\Models\BaseElement;
use gorriecoe\Link\Models\Link;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\HasManyList;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class LinksElement
 * @package Dynamic\Elements\Links\Elements
 *
 * @method HasManyList ElementLinks()
 */
class LinksElement extends BaseElement
{
    /**
     * @var string
     */
    private static $table_name = 'LinksElement';

    /**
     * @var string
     */
    private static $singular_name = 'Links Element';

    /**
     * @var string
     */
    private static $plural_name = 'Links Elements';

    /**
     * @var bool
     */
    private static $inline_editable = false;

    /**
     * @var array
     */
    private static $has_many = [
        'ElementLinks' => Link::class,
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            if (($links = $fields->dataFieldByName('ElementLinks')) && $links instanceof GridField) {
                $links->setTitle($this->fieldLabel('Links'));

                $fields->removeByName('ElementLinks');

                $links->getConfig()
                    ->addComponents(new GridFieldOrderableRows('ElementLinksSort'));

                $fields->addFieldToTab('Root.Main', $links);
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return DBHTMLText
     */
    public function getSummary()
    {
        $count = $this->ElementLinks()->count();
        $label = _t(
            Link::class . '.PLURALS',
            'A link|{count} links',
            ['count' => $count]
        );
        return DBField::create_field('HTMLText', $label)->Summary(20);
    }

    /**
     * @return array
     */
    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        //$blockSchema['content'] = $this->getSummary();
        return $blockSchema;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Links');
    }
}
