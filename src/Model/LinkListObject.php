<?php

namespace Dynamic\Elements\Links\Model;

use gorriecoe\Link\Models\Link;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use gorriecoe\LinkField\LinkField;
use Dynamic\Elements\Links\Elements\LinksElement;

class LinkListObject extends DataObject
{
    /**
     * @var string
     */
    private static $singular_name = 'Link';

    /**
     * @var string
     */
    private static $plural_name = 'Links';

    /**
     * @var array
     */
    private static $db = [
        'Content' => 'HTMLText',
        'SortOrder' => "Int",
    ];

    /**
     * @var array
     */
    private static $has_one = [
        'LinkList' => LinksElement::class,
        'Link' => Link::class,
    ];

    /**
     * @var array
     */
    private static $summary_fields = [
        'Link.Title',
        'Link.LinkURL',
    ];

    /**
     * @var string
     */
    private static $table_name = 'LinkListObject';

    /**
     * @param bool $includerelations
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Link.Title'] = _t(__CLASS__.'.LinkTitleLabel', 'Link');
        $labels['Link.LinkURL'] = _t(__CLASS__.'.LinkURLLabel', 'Link URL');
        $labels['Link'] = _t(__CLASS__.'.LinkLabel', 'Link');

        return $labels;
    }

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->replaceField(
                'LinkID',
                LinkField::create('Link', $this->fieldLabel('Link'), $this)
            );

            $fields->insertBefore(
                'Content',
                $fields->dataFieldByName('Link')
            );

            $fields->dataFieldByName('Content')
                ->setTitle($this->fieldLabel('Description'))
                ->setRows(5);

            $fields->removeByName([
                'LinkListID',
                'SortOrder',
            ]);
        });

        return parent::getCMSFields();
    }

    /**
     * return Title
     *
     * @return void
     */
    public function getTitle()
    {
        return $this->Link()->Title;
    }
}
