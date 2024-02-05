<?php

namespace Dynamic\Elements\Links\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\LinkField\JsonData;
use SilverStripe\LinkField\ORM\DBLink;
use SilverStripe\LinkField\Type\Registry;
use SilverStripe\LinkField\Form\LinkField;
use Dynamic\Elements\Links\Elements\LinksElement;

/**
 * Class \Dynamic\Elements\Links\Model\LinkListObject
 *
 * @property string $Title
 * @property string $Content
 * @property string $ElementLink
 * @property int $SortOrder
 * @property int $LinkListID
 * @method LinksElement LinkList()
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
        'ElementLink' => DBLink::class,
        'SortOrder' => "Int",
    ];

    /**
     * @var array
     * @config
     */
    private static $has_one = [
        'LinkList' => LinksElement::class,
    ];

    /**
     * @var array
     * @config
     */
    private static $summary_fields = [
        'Title',
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
        $labels['Description'] = _t(__CLASS__ . '.DescriptionLabel', 'Description');
        $labels['Link.Title'] = _t(__CLASS__ . '.LinkTitleLabel', 'Link');
        $labels['Link.LinkURL'] = _t(__CLASS__ . '.LinkURLLabel', 'Link URL');
        $labels['Link'] = _t(__CLASS__ . '.LinkLabel', 'Link');

        return $labels;
    }

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {

            $fields->removeByName([
                'ElementLink',
                'LinkListID',
                'SortOrder',
            ]);
            
            $fields->addFieldToTab('Root.Main', $title = TextField::create('Title'), 'Content');
            $title->setTitle($this->fieldLabel('Title'));

            // @phpstan-ignore-next-line
            $fields->dataFieldByName('Content')
                ->setTitle($this->fieldLabel('Description'))
                ->setRows(5);

            $fields->addFieldToTab('Root.Main', $link = LinkField::create('ElementLink'));
            $link->setTitle($this->fieldLabel('Link'));
        });

        return parent::getCMSFields();
    }

    /**
     * @return JsonData|null
     */
    public function getLinkObject(): ?JsonData
    {
        $link = $this->dbObject('ElementLink');

        $value = $link->getValue();

        if ($value) {
            $type = Registry::singleton()->byKey($value['typeKey']);

            if ($type) {
                return $type->loadLinkData($value);
            }
        }

        return null;
    }
}
