<?php

namespace Dynamic\Elements\Links\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Versioned\Versioned;
use SilverStripe\LinkField\Models\Link;
use SilverStripe\LinkField\Form\LinkField;
use Dynamic\Elements\Links\Elements\LinksElement;
use DNADesign\Elemental\Forms\TextCheckboxGroupField;

/**
 * Class \Dynamic\Elements\Links\Model\LinkListObject
 *
 * @property int $Version
 * @property string $Title
 * @property bool $ShowTitle
 * @property string $Content
 * @property int $SortOrder
 * @property int $LinkListID
 * @property int $LinkID
 * @method LinksElement LinkList()
 * @method Link Link()
 * @mixin Versioned
 */
class LinkListObject extends DataObject
{
    /**
     * @var string
     * @config
     */
    private static $singular_name = 'Link';

    /**
     * @var string
     * @config
     */
    private static $plural_name = 'Links';

    /**
     * @var array
     * @config
     */
    private static $db = [
        'Title' => 'Varchar(255)',
        'ShowTitle' => 'Boolean',
        'Content' => 'HTMLText',
        'SortOrder' => "Int",
    ];

    /**
     * @var array
     * @config
     */
    private static $has_one = [
        'LinkList' => LinksElement::class,
        'Link' => Link::class,
    ];

    /**
     * @var array
     * @config
     */
    private static $owns = [
        'Link',
    ];

    /**
     * @var array
     * @config
     */
    private static $extensions = [
        Versioned::class,
    ];

    /**
     * @var array
     * @config
     */
    private static $summary_fields = [
        'Title',
        'Link.Title',
        'Link.ClassName.ShortName' => 'Type',
    ];

    /**
     * @var string
     * @config
     */
    private static $table_name = 'LinkListObject';

    /**
     * @param bool $includerelations
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Title'] = _t(__CLASS__ . '.TitleLabel', 'Title');
        $labels['Content'] = _t(__CLASS__ . '.ContentLabel', 'Description');
        $labels['Link'] = _t(__CLASS__ . '.LinkLabel', 'Link');
        $labels['Link.Title'] = _t(__CLASS__ . '.LinkTitleLabel', 'Link');

        return $labels;
    }

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {

            $fields->removeByName([
                'LinkListID',
                'SortOrder',
            ]);

            // Add a combined field for "Title" and "Displayed" checkbox in a Bootstrap input group
            $fields->removeByName('ShowTitle');
            $fields->replaceField(
                'Title',
                TextCheckboxGroupField::create()
                    ->setName('Title')
                    ->setTitle($this->fieldLabel('Title'))
            );
            
            // @phpstan-ignore-next-line
            $fields->dataFieldByName('Content')
                ->setRows(5);

            $fields->replaceField(
                'LinkID',
                LinkField::create('Link')
                    ->setTitle($this->fieldLabel('Link'))
            );
        });

        return parent::getCMSFields();
    }
}
