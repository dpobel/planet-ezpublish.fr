<?php

namespace Planet\PlanetBundle\Tests\Import;

use PHPUnit_Framework_TestCase,
    Planet\PlanetBundle\Import\PostImportStruct,
    eZ\Publish\API\Repository\UserService,
    eZ\Publish\API\Repository\ContentTypeService;


class PostImportStructTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider dataWrongParameters
     * @expectedException InvalidArgumentException
     */
    function testWrongParameter( $userId, $typeIdentifier, $parentLocationId, array $mapping )
    {
        new PostImportStruct( $userId, $typeIdentifier, $parentLocationId, $mapping );
    }

    public function dataWrongParameters()
    {
        return array(
            array( 'aa', 2, 'aa', array() ),
            array( 14, 2, 'aa', array() ),
            array( 14, 'post', 'aa', array() ),
        );
    }

    function testGetters()
    {
        $userId = 14;
        $typeIdentifier = 'post';
        $parentLocationId = 60;
        $mapping = array(
            'title' => 'title',
            'text' => 'html',
            'url' => 'link'
        );

        $userServiceMock = $this->getMock(
            'eZ\\Publish\\API\\Repository\\UserService'
        );
        $userServiceMock->expects( $this->once() )
            ->method( 'loadUser' )
            ->with( $this->equalTo( $userId ) );
        $typeServiceMock = $this->getMock(
            'eZ\\Publish\\API\\Repository\\ContentTypeService'
        );
        $typeServiceMock->expects( $this->once() )
            ->method( 'loadContentTypeByIdentifier' )
            ->with( $this->equalTo( $typeIdentifier ) );

        $struct = new PostImportStruct(
            $userId, $typeIdentifier, $parentLocationId, $mapping
        );

        self::assertTrue( is_integer( $struct->getUserId() ) );
        self::assertEquals( $userId, $struct->getUserId() );
        $struct->getUser( $userServiceMock );

        self::assertTrue( is_string( $struct->getContentTypeIdentifier() ) );
        self::assertEquals(
            $typeIdentifier, $struct->getContentTypeIdentifier()
        );
        $struct->getContentType( $typeServiceMock );

        self::assertTrue(
            is_integer( $struct->getParentLocationId() )
        );
        self::assertEquals(
            $parentLocationId, $struct->getParentLocationId()
        );

        self::assertTrue(
            is_array( $struct->getMapping() )
        );
        self::assertEquals(
            $mapping, $struct->getMapping()
        );
    }

}
