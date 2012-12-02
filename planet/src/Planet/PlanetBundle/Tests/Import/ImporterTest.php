<?php

namespace Planet\PlanetBundle\Tests\Import;

use PHPUnit_Framework_TestCase,
    InvalidArgumentException,
    DateTime,

    Planet\PlanetBundle\Import\Importer,
    Planet\PlanetBundle\Import\PostImportStruct,
    Planet\PlanetBundle\Import\Parser,
    Planet\PlanetBundle\Import\Post,
    Planet\PlanetBundle\Import\ImportResultStruct,

    eZ\Publish\Core\Base\Exceptions\NotFoundException,

    eZ\Publish\Core\MVC\ConfigResolverInterface,

    eZ\Publish\API\Repository\Repository,
    eZ\Publish\API\Repository\Values\Content\Content;


class ImporterTest extends PHPUnit_Framework_TestCase
{
    protected function getConfigResolverMock()
    {
        return $this->getMock(
            'eZ\\Publish\\Core\\MVC\\ConfigResolverInterface'
        );
    }

    protected function getRepositoryMock()
    {
        $mock = $this->getMock(
            'eZ\\Publish\\API\\Repository\\Repository'
        );
        $mock->expects( $this->any() )
            ->method( 'getUserService' )
            ->will( $this->returnValue( $this->getUserServiceMock() ) );

        $mock->expects( $this->any() )
            ->method( 'getContentTypeService' )
            ->will( $this->returnValue( $this->getContentTypeServiceMock() ) );

        $mock->expects( $this->any() )
            ->method( 'getContentService' )
            ->will( $this->returnValue( $this->getContentServiceMock() ) );
        return $mock;
    }

    protected function getParserMock()
    {
        return $this->getMock(
            'Planet\\PlanetBundle\\Import\\Parser'
        );
    }

    protected function getUserMock()
    {
        return $this->getMockForAbstractClass(
            'eZ\\Publish\\API\\Repository\\Values\\User\\User'
        );
    }

    protected function getUserServiceMock()
    {
        $mock = $this->getMock(
            'eZ\\Publish\\API\\Repository\\UserService'
        );

        $mock->expects( $this->any() )
            ->method( 'loadUser' )
            ->will( $this->returnValue( $this->getUserMock() ) );

        return $mock;
    }

    protected function getContentTypeServiceMock()
    {
        return $this->getMock(
            'eZ\\Publish\\API\\Repository\\ContentTypeService'
        );
    }

    protected function getContentServiceMock()
    {
        $mock = $this->getMock(
            'eZ\\Publish\\API\\Repository\\ContentService'
        );
        return $mock;
    }


    protected function getPost( $id, $title, $text, $url, DateTime $date )
    {
        $post = new Post();
        $post->id = $id;
        $post->title = $title;
        $post->text = $text;
        $post->url = $url;
        $post->publishedDate = $date;
        return $post;
    }

    public function testEmptyParseResult()
    {
        $config = $this->getConfigResolverMock();
        $repo = $this->getRepositoryMock();
        $parser = $this->getParserMock();
        $parser->expects( $this->once() )
            ->method( 'parse' )
            ->will( $this->returnValue( array() ) );

        $struct = new PostImportStruct( 14, 'post', 2, array() );

        $importer = new Importer( $repo, $config );
        $result = $importer->import( $struct, $parser );
        self::assertTrue( $result instanceof ImportResultStruct );
        self::assertEquals( array(), $result->getUnchanged() );
        self::assertEquals( array(), $result->getCreated() );
        self::assertEquals( array(), $result->getUpdated() );
    }


}

