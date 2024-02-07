<?php

namespace Dynamic\Elements\Links\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\LinkField\Form\LinkField;
use Dynamic\Elements\Links\Elements\LinksElement;
use SilverStripe\LinkField\Models\Link;

/**
 * Class \Dynamic\Elements\Links\Model\LinkListObject
 *
 * @property string $Title
 * @property string $Content
 * @property int $SortOrder
 * @property int $LinkListID
 * @property int $LinkID
 * @method LinksElement LinkList()
 * @method Link Link()
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
    private static $summary_fields = [
        'Title',
        'Link.Title',
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
