<?php

// Include our base testSetup class.
require_once dirname(__FILE__) . '/../../testSetup.php';
// Include the Open-Realty API Class
require_once dirname(__FILE__) . '/../../../../api/api.inc.php';

/**
 * Integration Test for the Media API
 */
class MediaTest extends testSetup
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
     * Test creating a user photo from local file.
     *
     * @return void
     */
    public function testCreateUserPhoto()
    {
        global $config;
        $api = new api();
        $data = ['media_parent_id' => 1,
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
        $this->assertFalse($result['media_error']['sincerely-media-l6ysDz2m6nM-unsplash.jpg']);
        $this->tester->seeInDatabase('default_en_userimages', ['userdb_id' => '1', 'userimages_description' => 'Test Description', 'userimages_caption' => 'Test Caption', 'userimages_active' => 'yes', 'userimages_file_name' => 'sincerely-media-l6ysDz2m6nM-unsplash.jpg', 'userimages_thumb_file_name'=>'thumb_sincerely-media-l6ysDz2m6nM-unsplash.jpg']);
        $this->tester->seeFileFound('sincerely-media-l6ysDz2m6nM-unsplash.jpg', $config['basepath'] . '/images/user_photos/');
        $this->tester->seeFileFound('thumb_sincerely-media-l6ysDz2m6nM-unsplash.jpg', $config['basepath'] . '/images/user_photos/');
    }
    
    /**
     * Test creating a user photo from a remote file and storing it locally in open-realty.
     *
     * @return void
     */
    public function testCreateUserRemotePhotoDownload()
    {
        global $config;
        $api = new api();
        $data = ['media_parent_id' => 1,
        'media_type' => 'userimages',
        'media_data' => [
            'michael-dam-mEZ3PoFGs_k-unsplash.jpg' => [
                'caption' => 'Test Caption',
                'description' => 'Test Description',
                'data' => $config['baseurl'].'/tests/_assets/test_data/images/users/michael-dam-mEZ3PoFGs_k-unsplash.jpg',
                'remote' => false
            ]]];
        $result = $api->load_local_api('media__create', $data, INT_USER, INT_PASS);
        $this->assertArrayHasKey('error', $result);
        $this->assertFalse($result['error']);
        $this->assertArrayHasKey('media_error', $result);
        $this->assertArrayHasKey('michael-dam-mEZ3PoFGs_k-unsplash.jpg', $result['media_error']);
        $this->assertFalse($result['media_error']['michael-dam-mEZ3PoFGs_k-unsplash.jpg']);
        $this->tester->seeInDatabase('default_en_userimages', ['userdb_id' => '1', 'userimages_description' => 'Test Description', 'userimages_caption' => 'Test Caption', 'userimages_active' => 'yes', 'userimages_file_name' => 'michael-dam-mEZ3PoFGs_k-unsplash.jpg', 'userimages_thumb_file_name'=>'thumb_michael-dam-mEZ3PoFGs_k-unsplash.jpg']);
        $this->tester->seeFileFound('michael-dam-mEZ3PoFGs_k-unsplash.jpg', $config['basepath'] . '/images/user_photos/');
        $this->tester->seeFileFound('thumb_michael-dam-mEZ3PoFGs_k-unsplash.jpg', $config['basepath'] . '/images/user_photos/');
    }
    
    /**
     * Test creating a user photo from a remote file and storing it locally in open-realty that is to large and should return an error.
     *
     * @return void
     */
    public function testCreateUserRemotePhotoDownloadToLarge()
    {
        global $config;
        $api = new api();
        $data = ['media_parent_id' => 1,
        'media_type' => 'userimages',
        'media_data' => [
            'michael-dam-mEZ3PoFGs_k-unsplash_tolarge.jpg' => [
                'caption' => 'Test Caption',
                'description' => 'Test Description',
                'data' => $config['baseurl'].'/tests/_assets/test_data/images/users/michael-dam-mEZ3PoFGs_k-unsplash_tolarge.jpg',
                'remote' => false
            ]]];
        $result = $api->load_local_api('media__create', $data, INT_USER, INT_PASS);
        $this->assertArrayHasKey('error', $result);
        $this->assertFalse($result['error']);
        $this->assertArrayHasKey('media_error', $result);
        $this->assertArrayHasKey('michael-dam-mEZ3PoFGs_k-unsplash_tolarge.jpg', $result['media_error']);
        $this->assertTrue($result['media_error']['michael-dam-mEZ3PoFGs_k-unsplash_tolarge.jpg']);
        
        $this->assertArrayHasKey('media_response', $result);
        $this->assertArrayHasKey('michael-dam-mEZ3PoFGs_k-unsplash_tolarge.jpg', $result['media_response']);
        $this->assertEquals('The file is too large', $result['media_response']['michael-dam-mEZ3PoFGs_k-unsplash_tolarge.jpg']);
        $this->tester->dontSeeInDatabase('default_en_userimages', ['userdb_id' => '1', 'userimages_description' => 'Test Description', 'userimages_caption' => 'Test Caption', 'userimages_active' => 'yes', 'userimages_file_name' => 'michael-dam-mEZ3PoFGs_k-unsplash_tolarge.jpg', 'userimages_thumb_file_name'=>'thumb_michael-dam-mEZ3PoFGs_k-unsplash_tolarge.jpg']);
        $this->tester->dontSeeFileFound('michael-dam-mEZ3PoFGs_k-unsplash_tolarge.jpg', $config['basepath'] . '/images/user_photos/');
        $this->tester->dontSeeFileFound('thumb_michael-dam-mEZ3PoFGs_k-unsplash_tolarge.jpg', $config['basepath'] . '/images/user_photos/');
    }
    
    /**
     * Test creating a user photo from a remote file and linking to the remote URL in open-realty.
     *
     * @return void
     */
    public function testCreateUserRemotePhotoLink()
    {
        global $config;
        $api = new api();
        $data = ['media_parent_id' => 1,
        'media_type' => 'userimages',
        'media_data' => [
            'michael-dam-mEZ3PoFGs_k-unsplash.jpg' => [
                'caption' => 'Test Caption',
                'description' => 'Test Description',
                'data' => $config['baseurl'].'/tests/_assets/test_data/images/users/michael-dam-mEZ3PoFGs_k-unsplash.jpg',
                'remote' => true
            ]]];
        $result = $api->load_local_api('media__create', $data, INT_USER, INT_PASS);
        $this->assertArrayHasKey('error', $result);
        $this->assertFalse($result['error']);
        $this->assertArrayHasKey('media_error', $result);
        $this->assertArrayHasKey('michael-dam-mEZ3PoFGs_k-unsplash.jpg', $result['media_error']);
        $this->assertFalse($result['media_error']['michael-dam-mEZ3PoFGs_k-unsplash.jpg']);
        $this->tester->seeInDatabase('default_en_userimages', ['userdb_id' => '1', 'userimages_description' => 'Test Description', 'userimages_caption' => 'Test Caption', 'userimages_active' => 'yes', 'userimages_file_name' => $config['baseurl'].'/tests/_assets/test_data/images/users/michael-dam-mEZ3PoFGs_k-unsplash.jpg', 'userimages_thumb_file_name'=>$config['baseurl'].'/tests/_assets/test_data/images/users/michael-dam-mEZ3PoFGs_k-unsplash.jpg']);
        $this->tester->dontSeeFileFound('michael-dam-mEZ3PoFGs_k-unsplash.jpg', $config['basepath'] . '/images/user_photos/');
        $this->tester->dontSeeFileFound('thumb_michael-dam-mEZ3PoFGs_k-unsplash.jpg', $config['basepath'] . '/images/user_photos/');
    }
}
