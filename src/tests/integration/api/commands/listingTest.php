<?php

// Include our base testSetup class.
require_once dirname(__FILE__) . '/../../testSetup.php';
// Include the Open-Realty API Class
require_once dirname(__FILE__) . '/../../../../api/api.inc.php';

/**
 * Test the Listing API
 */
class ListingTest extends testSetup
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        parent::_before();
    }

    protected function _after()
    {
        parent::_after();
    }

    /**
     * Test the Listing Search API respects the count_only parameter being true
     *
     * @return void
     */
    public function test_listing_search_count_only()
    {
        $api = new api();
        $data = ['parameters' => [], 'limit' => 0, 'offset' => 0, 'count_only' => 1];
        $result = $api->load_local_api('listing__search', $data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertArrayHasKey('listing_count', $result);
        $this->assertArrayHasKey('listings', $result);
        $this->assertEquals(4, $result['listing_count']);
        $this->assertEmpty($result['listings']);
    }
    
    /**
     * Test the Listing Search API respects the count_only parameter being false and returns the listing IDs instead.
     *
     * @return void
     */
    public function test_listing_search_returns_listing_ids()
    {
        $api = new api();
        $data = ['parameters' => [], 'limit' => 0, 'offset' => 0, 'count_only' => 0];
        $result = $api->load_local_api('listing__search', $data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertArrayHasKey('listing_count', $result);
        $this->assertArrayHasKey('listings', $result);
        $this->assertEquals(4, $result['listing_count']);
        $this->assertEqualsCanonicalizing([1, 2, 3, 4], $result['listings']);
    }
    
    /**
     * Test the the Listing Search API respects the limit parameter
     *
     * @return void
     */
    public function test_listing_search_limit()
    {
        $api = new api();
        $data = ['parameters' => [], 'limit' => 2, 'offset' => 0, 'count_only' => 0];
        $result = $api->load_local_api('listing__search', $data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertArrayHasKey('listing_count', $result);
        $this->assertArrayHasKey('listings', $result);
        $this->assertEquals(2, $result['listing_count']);
        $this->assertEqualsCanonicalizing([1, 2], $result['listings']);
    }

    /**
     * Test Listing Search API, Offset requires a limit, if we do not set both we should get all listings.
     * @return void
     */
    public function test_listing_search_offset_without_limit()
    {
        $api = new api();
        $data = ['parameters' => [], 'limit' => 0, 'offset' => 1, 'count_only' => 0];
        $result = $api->load_local_api('listing__search', $data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertArrayHasKey('listing_count', $result);
        $this->assertArrayHasKey('listings', $result);
        $this->assertEquals(4, $result['listing_count']);
        $this->assertEqualsCanonicalizing([1, 2, 3, 4], $result['listings']);
    }
    /**
     * Test Listing Search API correctly offsets the listings when we pass a limit & offset
     *
     * @return void
     */
    public function test_listing_search_offset_with_limit()
    {
        $api = new api();
        $data = ['parameters' => [], 'limit' => 2, 'offset' => 1, 'count_only' => 0];
        $result = $api->load_local_api('listing__search', $data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertArrayHasKey('listing_count', $result);
        $this->assertArrayHasKey('listings', $result);
        $this->assertEquals(2, $result['listing_count']);
        $this->assertEqualsCanonicalizing([2, 3], $result['listings']);
    }

    /**
     * Test the Listing Read API allows reading internal fields, in this case the listingsdb_pclass_id
     *
     * @return void
     */
    public function test_listing_read_internal_fields()
    {
        $api = new api();
        $data = ['listing_id' => 1, 'fields' => ['listingsdb_id', 'listingsdb_pclass_id']];
        $result = $api->load_local_api('listing__read', $data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertFalse($result['error']);
        $this->assertArrayHasKey('listing', $result);
        $this->assertArrayHasKey('listingsdb_id', $result['listing']);
        $this->assertArrayHasKey('listingsdb_pclass_id', $result['listing']);
        $this->assertEquals(1, $result['listing']['listingsdb_id']);
        $this->assertEquals(1, $result['listing']['listingsdb_pclass_id']);
    }

    /**
     * Test the Listing Read API allows reading custom fields, in this case the price
     *
     * @return void
     */
    public function test_listing_read_custom_fields()
    {
        $api = new api();
        $data = ['listing_id' => 1, 'fields' => ['listingsdb_id', 'price']];
        $result = $api->load_local_api('listing__read', $data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertFalse($result['error']);
        $this->assertArrayHasKey('listing', $result);
        $this->assertArrayHasKey('listingsdb_id', $result['listing']);
        $this->assertArrayHasKey('price', $result['listing']);
        $this->assertEquals(1, $result['listing']['listingsdb_id']);
        $this->assertEquals(2500000, $result['listing']['price']);
    }

    
    /**
     * Test that we can update a listing custom field, price, with Listing Update and then read the change back with the Listing Read API.
     *
     * @return void
     */
    public function test_listing_update_custom_fields()
    {
        $api = new api();
        $data = ['listing_id' => 1, 'class_id' => 1, 'listing_fields' => ['price' => 500]];
        $result = $api->load_local_api('listing__update', $data, INT_USER, INT_PASS);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertFalse($result['error']);

        $data = ['listing_id' => 1, 'fields' => ['listingsdb_id', 'price']];
        $result = $api->load_local_api('listing__read', $data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertFalse($result['error']);
        $this->assertArrayHasKey('listing', $result);
        $this->assertArrayHasKey('listingsdb_id', $result['listing']);
        $this->assertArrayHasKey('price', $result['listing']);
        $this->assertEquals(1, $result['listing']['listingsdb_id']);
        $this->assertEquals(500, $result['listing']['price']);
    }

    /**
     * Test that trying to delete a listing that you are not the listing agent of fails.
     *
     * @return void
     */
    public function test_listing_delete_other_agent_listing()
    {
        $api = new api();

        //Create Test Agent
        $data = ['user_details' => ['user_name'=>'agent1', 'user_first_name'=> 'Test', 'user_last_name'=>'Agent','emailaddress'=>'agent1@integrationtest.open-realty.org','user_password'=>'password','active'=>'yes','is_agent'=>'yes']];
        $result = $api->load_local_api('user__create', $data, INT_USER, INT_PASS);
        $this->assertArrayHasKey('error', $result);
        $this->assertFalse($result['error']);
        @session_destroy();
        $_SESSION=array();

        $data = ['listing_id' => 1, 'fields' => ['listingsdb_id', 'price']];
        $result = $api->load_local_api('listing__delete', $data, 'agent1', 'password');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertTrue($result['error']);
        $this->assertEquals('Permission Denied (edit_all_listings)', $result['error_msg']);
    }

    /**
     * Test that anonymous API users can not delete listings
     *
     * @return void
     */
    public function test_listing_delete_listing_anonymous()
    {
        $api = new api();
        $data = ['listing_id' => 1];
        $result = $api->load_local_api('listing__delete', $data);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertTrue($result['error']);
        $this->assertEquals('Login Failure', $result['error_msg']);
    }

    /**
     * Test that you can delete a listing you are the listing agent for.
     *
     * @return void
     */
    public function test_listing_delete_my_listing()
    {
        global $config;
        $api = new api();
        $data = ['listing_id' => 1];
        $result = $api->load_local_api('listing__delete', $data, INT_USER, INT_PASS);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertFalse($result['error']);
        $this->assertEquals(1, $result['listing_id']);
        $this->tester->dontSeeFileFound('1_china_room.jpg', $config['basepath'].'/images/listing_photos/');
        $this->tester->dontSeeFileFound('1_dining_room.jpg', $config['basepath'].'/images/listing_photos/');
        $this->tester->dontSeeFileFound('1_green_room.jpg', $config['basepath'].'/images/listing_photos/');
        $this->tester->dontSeeFileFound('1_vermeil_room.jpg', $config['basepath'].'/images/listing_photos/');
        $this->tester->dontSeeFileFound('1_white-house.jpg', $config['basepath'].'/images/listing_photos/');
        $this->tester->dontSeeFileFound('thumb_1_china_room.jpg', $config['basepath'].'/images/listing_photos/');
        $this->tester->dontSeeFileFound('thumb_1_dining_room.jpg', $config['basepath'].'/images/listing_photos/');
        $this->tester->dontSeeFileFound('thumb_1_green_room.jpg', $config['basepath'].'/images/listing_photos/');
        $this->tester->dontSeeFileFound('thumb_1_vermeil_room.jpg', $config['basepath'].'/images/listing_photos/');
        $this->tester->dontSeeFileFound('thumb_1_white-house.jpg', $config['basepath'].'/images/listing_photos/');
    }
}
