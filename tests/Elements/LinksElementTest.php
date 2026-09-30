<?php

namespace Dynamic\Elements\Links\Test;

use Dynamic\Elements\Links\Elements\LinksElement;
use Dynamic\Elements\Links\Model\LinkListObject;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\FieldList;
use SilverStripe\LinkField\Models\ExternalLink;

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

    /**
     * Duplicating a LinkListObject must fork its Link record instead of sharing the original's.
     */
    public function testDuplicateForksLink(): void
    {
        $link = ExternalLink::create();
        $link->ExternalUrl = 'https://example.com/original';
        $link->write();

        $object = LinkListObject::create();
        $object->LinkID = $link->ID;
        $object->LinkListID = $this->objFromFixture(LinksElement::class, 'one')->ID;
        $object->write();

        $copy = $object->duplicate();

        $this->assertNotEquals(0, (int) $copy->LinkID, 'Duplicated record should still have a link');
        $this->assertNotEquals(
            $object->LinkID,
            $copy->LinkID,
            'Duplicated record must not share the original\'s Link row'
        );
        $this->assertEquals('https://example.com/original', $copy->Link()->ExternalUrl);

        $copy->Link()->ExternalUrl = 'https://example.com/forked';
        $copy->Link()->write();

        $this->assertEquals('https://example.com/forked', $copy->Link()->ExternalUrl);
        $this->assertEquals(
            'https://example.com/original',
            LinkListObject::get()->byID($object->ID)->Link()->ExternalUrl
        );
    }

    /**
     * A LinkListObject without a link must duplicate cleanly and stay linkless.
     */
    public function testDuplicateWithoutLink(): void
    {
        $object = LinkListObject::create();
        $object->LinkListID = $this->objFromFixture(LinksElement::class, 'one')->ID;
        $object->write();

        $copy = $object->duplicate();

        $this->assertSame(0, (int) $object->LinkID);
        $this->assertSame(0, (int) $copy->LinkID);
    }
}
