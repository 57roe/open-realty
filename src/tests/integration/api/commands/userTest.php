<?php

// Include our base testSetup class.
require_once dirname(__FILE__) . '/../../testSetup.php';
// Include the Open-Realty API Class
require_once dirname(__FILE__) . '/../../../../api/api.inc.php';

/**
 * Integration Test for the User API
 */
class UserTest extends testSetup
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
     * Test creating an agent with the User Create API
     *
     * @return void
     */
    public function testCreateAgent()
    {
        $api = new api();
        $data = ['user_details' => ['user_name'=>'agent1', 'user_first_name'=> 'Test', 'user_last_name'=>'Agent','emailaddress'=>'agent1@integrationtest.open-realty.org','user_password'=>'password','active'=>'yes','is_agent'=>'yes']];
        $result = $api->load_local_api('user__create', $data, INT_USER, INT_PASS);
        $this->assertArrayHasKey('error', $result);
        $this->assertFalse($result['error']);
        $this->tester->seeInDatabase('default_en_userdb', ['userdb_user_name' => 'agent1', 'userdb_emailaddress' => 'agent1@integrationtest.open-realty.org', 'userdb_is_admin' => 'no', 'userdb_is_agent' => 'yes', 'userdb_active'=> 'yes']);
    }
    protected function testCreateAgentImage()
    {
        global $config;
        $api = new api();
        $data = ['media_parent_id' => 2,
        'media_type' => 'userimages',
        'media_data' => [
            'sincerely-media-l6ysDz2m6nM-unsplash.jpg' => [
                'caption' => 'Test Caption',
                'description' => 'Test Description',
                'data' => file_get_contents(dirname(__FILE__) .'/../../../_assets/test_data/images/users/sincerely-media-l6ysDz2m6nM-unsplash.jpg')
            ]]];
        $result = $api->load_local_api('media__create', $data, INT_USER, INT_PASS);
        $this->assertArrayHasKey('error', $result);
        $this->assertFalse($result['error']);
        $this->assertArrayHasKey('media_error', $result);
        $this->assertArrayHasKey('sincerely-media-l6ysDz2m6nM-unsplash.jpg', $result['media_error']);
    }
    /**
     * Test deleting a user from the database.
     */
    public function testDeleteUser()
    {
        $api = new api();
        // $data = ['user_details' => ['user_name'=>'agent1', 'user_first_name'=> 'Test', 'user_last_name'=>'Agent','emailaddress'=>'agent1@integrationtest.open-realty.org','user_password'=>'password','active'=>'yes','is_agent'=>'yes']];
        // $result = $api->load_local_api('user__create', $data, INT_USER, INT_PASS);
        // $this->assertArrayHasKey('error', $result);
        // $this->assertFalse($result['error']);
        $this->testCreateAgent();
        $data = ['user_id'=>2];
        $result = $api->load_local_api('user__delete', $data, INT_USER, INT_PASS);
        $this->assertArrayHasKey('error', $result); // test
        $this->assertFalse($result['error']);
        $this->tester->dontSeeInDatabase('default_en_userdb', ['userdb_user_name' => 'agent1', 'userdb_emailaddress' => 'agent1@integrationtest.open-realty.org', 'userdb_is_admin' => 'no', 'userdb_is_agent' => 'yes', 'userdb_active'=> 'yes']);
    }
    /**
     * Test deleting a user from the database.
     */
    public function testDeleteUserWithImage()
    {
        global $config;
        $api = new api();
        // $data = ['user_details' => ['user_name'=>'agent1', 'user_first_name'=> 'Test', 'user_last_name'=>'Agent','emailaddress'=>'agent1@integrationtest.open-realty.org','user_password'=>'password','active'=>'yes','is_agent'=>'yes']];
        // $result = $api->load_local_api('user__create', $data, INT_USER, INT_PASS);
        // $this->assertArrayHasKey('error', $result);
        // $this->assertFalse($result['error']);
        $this->testCreateAgent();
        $this->testCreateAgentImage();
        $data = ['user_id'=>2];
        $result = $api->load_local_api('user__delete', $data, INT_USER, INT_PASS);
        $this->assertArrayHasKey('error', $result); // test
        $this->assertFalse($result['error']);
        $this->tester->dontSeeInDatabase('default_en_userdb', ['userdb_user_name' => 'agent1', 'userdb_emailaddress' => 'agent1@integrationtest.open-realty.org', 'userdb_is_admin' => 'no', 'userdb_is_agent' => 'yes', 'userdb_active'=> 'yes']);
        $this->tester->dontSeeInDatabase('default_en_userimages', ['userdb_id' => '2', 'userimages_description' => 'Test Description', 'userimages_caption' => 'Test Caption', 'userimages_active' => 'yes', 'userimages_file_name' => 'sincerely-media-l6ysDz2m6nM-unsplash.jpg', 'userimages_thumb_file_name'=>'thumb_sincerely-media-l6ysDz2m6nM-unsplash.jpg']);
        $this->tester->dontSeeFileFound('sincerely-media-l6ysDz2m6nM-unsplash.jpg', $config['basepath'] . '/images/user_photos/');
        $this->tester->dontSeeFileFound('thumb_sincerely-media-l6ysDz2m6nM-unsplash.jpg', $config['basepath'] . '/images/user_photos/');
    }
}
