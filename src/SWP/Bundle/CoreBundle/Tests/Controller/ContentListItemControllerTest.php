<?php

/*
 * This file is part of the Superdesk Web Publisher Core Bundle.
 *
 * Copyright 2015 Sourcefabric z.u. and contributors.
 *
 * For the full copyright and license information, please see the
 * AUTHORS and LICENSE files distributed with this source code.
 *
 * @copyright 2015 Sourcefabric z.ú
 * @license http://www.superdesk.org/license
 */

namespace SWP\Bundle\CoreBundle\Tests\Controller;

use SWP\Bundle\FixturesBundle\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Routing\RouterInterface;

class ContentListItemControllerTest extends WebTestCase
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var Client
     */
    protected $client;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        self::bootKernel();

        $this->initDatabase();
        $this->loadCustomFixtures(['tenant']);
        $this->router = $this->getContainer()->get('router');
        $this->client = static::createClient();

        $this->loadFixtureFiles([
            '@SWPFixturesBundle/Resources/fixtures/ORM/test/content_list.yml',
            '@SWPFixturesBundle/Resources/fixtures/ORM/test/list_content.yml',
            '@SWPFixturesBundle/Resources/fixtures/ORM/test/content_list_item.yml',
        ], true);
    }

    public function testListingContentListsItemsApi()
    {
        $this->client->request('GET', $this->router->generate('swp_api_core_list_items', ['id' => 1]));

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        $content = json_decode($this->client->getResponse()->getContent(), true);

        self::assertArraySubset(json_decode('{"page":1,"limit":10,"pages":1,"total":4,"_links":{"self":{"href":"\/api\/v1\/content\/lists\/1\/items\/?page=1&limit=10"},"first":{"href":"\/api\/v1\/content\/lists\/1\/items\/?page=1&limit=10"},"last":{"href":"\/api\/v1\/content\/lists\/1\/items\/?page=1&limit=10"}},"_embedded":{"_items":[{"id":1,"content":{"id":1,"title":"article1","body":"art1","slug":"article-1","publishedAt":null,"status":"published","route":{"id":3,"content":null,"staticPrefix":null,"variablePattern":"\/{slug}","root":3,"parent":null,"children":[],"level":0,"templateName":null,"articlesTemplateName":null,"type":"collection","cacheTimeInSeconds":0,"name":"news","position":2,"_links":{"self":{"href":"\/api\/v1\/content\/routes\/3"}}},"templateName":null,"publishStartDate":null,"publishEndDate":null,"isPublishable":true,"metadata":{"byline":"John Smith","located":"Berlin"},"media":[],"featureMedia":null,"lead":null,"keywords":[],"_links":{"self":{"href":"\/api\/v1\/content\/articles\/article-1"},"online":{"href":"\/article-1"}}},"position":0,"sticky":true,"enabled":true,"_links":{"list":{"href":"\/api\/v1\/content\/lists\/1"},"item":{"href":"\/api\/v1\/content\/lists\/1\/items\/1"}}},{"id":3,"content":{"id":3,"title":"article3","body":"art3","slug":"article-3","publishedAt":null,"status":"published","route":{"id":4,"content":null,"staticPrefix":null,"variablePattern":"\/{slug}","root":4,"parent":null,"children":[],"level":0,"templateName":null,"articlesTemplateName":null,"type":"collection","cacheTimeInSeconds":0,"name":"sport","position":3,"_links":{"self":{"href":"\/api\/v1\/content\/routes\/4"}}},"templateName":null,"publishStartDate":null,"publishEndDate":null,"isPublishable":true,"metadata":{"byline":"Adam Hide","located":"Sydney"},"media":[],"featureMedia":null,"lead":null,"keywords":[],"_links":{"self":{"href":"\/api\/v1\/content\/articles\/article-3"},"online":{"href":"\/article-3"}}},"position":2,"sticky":true,"enabled":true,"_links":{"list":{"href":"\/api\/v1\/content\/lists\/1"},"item":{"href":"\/api\/v1\/content\/lists\/1\/items\/3"}}},{"id":2,"content":{"id":2,"title":"article2","body":"art2","slug":"article-2","publishedAt":null,"status":"published","route":{"id":3,"content":null,"staticPrefix":null,"variablePattern":"\/{slug}","root":3,"parent":null,"children":[],"level":0,"templateName":null,"articlesTemplateName":null,"type":"collection","cacheTimeInSeconds":0,"name":"news","position":2,"_links":{"self":{"href":"\/api\/v1\/content\/routes\/3"}}},"templateName":null,"publishStartDate":null,"publishEndDate":null,"isPublishable":true,"metadata":{"byline":"John Smith","located":"Berlin"},"media":[],"featureMedia":null,"lead":null,"keywords":[],"_links":{"self":{"href":"\/api\/v1\/content\/articles\/article-2"},"online":{"href":"\/article-2"}}},"position":1,"sticky":false,"enabled":true,"_links":{"list":{"href":"\/api\/v1\/content\/lists\/1"},"item":{"href":"\/api\/v1\/content\/lists\/1\/items\/2"}}},{"id":4,"content":{"id":4,"title":"article4","body":"art4","slug":"article-4","publishedAt":null,"status":"published","route":{"id":4,"content":null,"staticPrefix":null,"variablePattern":"\/{slug}","root":4,"parent":null,"children":[],"level":0,"templateName":null,"articlesTemplateName":null,"type":"collection","cacheTimeInSeconds":0,"name":"sport","position":3,"_links":{"self":{"href":"\/api\/v1\/content\/routes\/4"}}},"templateName":null,"publishStartDate":null,"publishEndDate":null,"isPublishable":true,"metadata":{"byline":"Adam Hide","located":"Sydney"},"media":[],"featureMedia":null,"lead":null,"keywords":[],"_links":{"self":{"href":"\/api\/v1\/content\/articles\/article-4"},"online":{"href":"\/article-4"}}},"position":3,"sticky":false,"enabled":true,"_links":{"list":{"href":"\/api\/v1\/content\/lists\/1"},"item":{"href":"\/api\/v1\/content\/lists\/1\/items\/4"}}}]}}', true), $content);
    }

    public function testGetSingleContentListItem()
    {
        $this->client->request('GET', $this->router->generate('swp_api_core_show_lists_item', [
            'id' => 1,
            'listId' => 1,
        ]));

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        $content = json_decode($this->client->getResponse()->getContent(), true);

        self::assertArraySubset(json_decode('{"id":1,"content":{"id":1,"title":"article1","body":"art1","slug":"article-1","publishedAt":null,"status":"published","route":{"id":3,"content":null,"staticPrefix":null,"variablePattern":"\/{slug}","root":3,"parent":null,"children":[],"level":0,"templateName":null,"articlesTemplateName":null,"type":"collection","cacheTimeInSeconds":0,"name":"news","position":2,"_links":{"self":{"href":"\/api\/v1\/content\/routes\/3"}}},"templateName":null,"publishStartDate":null,"publishEndDate":null,"isPublishable":true,"metadata":{"byline":"John Smith","located":"Berlin"},"media":[],"featureMedia":null,"lead":null,"keywords":[],"_links":{"self":{"href":"\/api\/v1\/content\/articles\/article-1"},"online":{"href":"\/article-1"}}},"position":0,"sticky":true,"enabled":true,"_links":{"list":{"href":"\/api\/v1\/content\/lists\/1"},"item":{"href":"\/api\/v1\/content\/lists\/1\/items\/1"}}}', true), $content);
    }

    public function testGetSingleListItemWhenItemDoesntExist()
    {
        $this->client->request('GET', $this->router->generate('swp_api_core_show_lists_item', [
            'id' => 9999,
            'listId' => 1,
        ]));

        self::assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testGetSingleListItemWhenListDoesntExist()
    {
        $this->client->request('GET', $this->router->generate('swp_api_core_show_lists_item', [
            'id' => 2,
            'listId' => 9999,
        ]));

        self::assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function testStickUnstickListItemContent()
    {
        $this->client->request('PATCH', $this->router->generate('swp_api_core_update_lists_item', [
            'id' => 2,
            'listId' => 1,
        ]), [
            'content_list_item' => [
                'sticky' => true,
            ],
        ]);

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', $this->router->generate('swp_api_core_show_lists_item', [
            'id' => 2,
            'listId' => 1,
        ]));

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        $content = json_decode($this->client->getResponse()->getContent(), true);

        self::assertArraySubset(json_decode('{"sticky":true}', true), $content);

        $this->client->request('PATCH', $this->router->generate('swp_api_core_update_lists_item', [
            'id' => 2,
            'listId' => 1,
        ]), [
            'content_list_item' => [
                'sticky' => false,
            ],
        ]);

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', $this->router->generate('swp_api_core_show_lists_item', [
            'id' => 2,
            'listId' => 1,
        ]));

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        $content = json_decode($this->client->getResponse()->getContent(), true);

        self::assertArraySubset(json_decode('{"sticky":false}', true), $content);
    }
}
