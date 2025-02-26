<?php

namespace Dynamic\Elements\Links\Elements;

use DNADesign\Elemental\Models\BaseElement;
use Dynamic\Elements\Links\Model\LinkListObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\ORM\FieldType\DBField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Class LinksElement
 *
 * @property string $Content
 * @method DataList|LinkListObject[] ElementLinks()
 */
class LinksElement extends BaseElement
{
    /**
     * @var string
     * @config
     */
    private static $table_name = 'LinksElement';

    /**
     * @var array
     * @config
     */
    private static $db = [
        'Content' => 'HTMLText',
    ];

    /**
     * @var string
     * @config
     */
    private static $singular_name = 'Links Element';

    /**
     * @var string
     * @config
     */
    private static $plural_name = 'Links Elements';

    /**
     * @var bool
     * @config
     */
    private static $inline_editable = false;

    /**
     * @var array
     * @config
     */
    private static $has_many = [
        'ElementLinks' => LinkListObject::class,
    ];

    /**
     * @var array
     * @config
     */
    private static $owns = [
        'ElementLinks',
    ];

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->dataFieldByName('Content')
                ->setRows(8);

            if (($links = $fields->dataFieldByName('ElementLinks')) && $links instanceof GridField) {
                $links->setTitle($this->fieldLabel('Links'));

                $fields->removeByName('ElementLinks');

                $links->getConfig()
                    ->addComponents([
                        new GridFieldOrderableRows('SortOrder'),
                    ])
                    ->removeComponentsByType([
                        GridFieldAddExistingAutocompleter::class,
                        GridFieldDeleteAction::class,
                    ])
                ;

                $fields->addFieldToTab('Root.Main', $links);
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        $count = $this->ElementLinks()->count();
        $label = _t(
            LinkListObject::class . '.PLURALS',
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
        $blockSchema['content'] = $this->getSummary();
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
