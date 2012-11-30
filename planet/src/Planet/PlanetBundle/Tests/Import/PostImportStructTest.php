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
    function testWrongParameter( $userId, $typeIdentifier, $parentLocationId )
    {
        new PostImportStruct( $userId, $typeIdentifier, $parentLocationId );
    }

    public function dataWrongParameters()
    {
        return array(
            array( 'aa', 2, 'aa' ),
            array( 14, 2, 'aa' ),
            array( 14, 'post', 'aa' ),
        );
    }

    function testGetters()
    {
        $userId = 14;
        $typeIdentifier = 'post';
        $parentLocationId = 60;

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
            $userId, $typeIdentifier, $parentLocationId
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
    }

}
