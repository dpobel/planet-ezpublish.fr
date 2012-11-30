<?php

namespace Planet\PlanetBundle\Tests\Import;

use PHPUnit_Framework_TestCase,
    Planet\PlanetBundle\Import\ImportResultStruct;


class ImportResultStructTest extends PHPUnit_Framework_TestCase
{
    protected $result;

    protected function setUp()
    {
        $this->result = new ImportResultStruct();
    }

    protected function getContentMock()
    {
        return $this->getMockForAbstractClass(
            'eZ\\Publish\\API\\Repository\\Values\\Content\\Content'
        );
    }

    public function contentProvider()
    {
        return array(
            array(
                array(
                    $this->getContentMock(),
                    $this->getContentMock(),
                    $this->getContentMock(),
                    $this->getContentMock(),
                    $this->getContentMock(),
                )
            ),
            array( array() ),
        );
    }

    /**
     * @dataProvider contentProvider
     */
    public function testCreated( array $mocks )
    {
        $this->abstractTest( 'created', $mocks );
    }

    /**
     * @dataProvider contentProvider
     */
    public function testUpdated( array $mocks )
    {
        $this->abstractTest( 'updated', $mocks );
    }

    /**
     * @dataProvider contentProvider
     */
    public function testUnchanged( array $mocks )
    {
        $this->abstractTest( 'unchanged', $mocks );
    }

    protected function abstractTest( $suffix, $mocks )
    {
        foreach ( $mocks as $mock )
        {
            $this->result->{'add' . $suffix}( $mock );
        }

        $created = $this->result->{'get' . $suffix}();
        self::assertEquals( count( $mocks ), count( $created ) );
        foreach ( $created as $k => $c )
        {
            self::assertEquals( $mocks[$k], $c );
        }
    }

}
