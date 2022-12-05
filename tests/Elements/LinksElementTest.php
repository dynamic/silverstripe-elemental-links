<?php

namespace Dynamic\Elements\Links\Test;

use Dynamic\Elements\Links\Elements\LinksElement;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;

class LinksElementTest extends SapphireTest
{
    /**
     * @var string
     */
    protected static $fixture_file = '../fixtures.yml';

    /**
     *
     */
    public function testGetCMSFields()
    {
        $object = $this->objFromFixture(LinksElement::class, 'one');
        $fields = $object->getCMSFields();
        $this->assertInstanceOf(FieldList::class, $fields);
        $this->assertNull($fields->dataFieldByName('SortOrder'));
    }
}
