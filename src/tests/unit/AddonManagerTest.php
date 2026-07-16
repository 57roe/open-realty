<?php

// Include our base testSetup class.
require_once dirname(__FILE__) . '/testSetup.php';
// Include the AddonManager class we need to test
require_once(dirname(__FILE__).'/../../include/addon_manager.inc.php');

/**
 *  Unit Test for the AddonManager Class in src/include/addon_manager.inc.php
 */
class AddonManagerTest extends testSetup
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
     * Test the parse_store_response function
     * This function reads our list of addons from https://www.open-realty.org/addons.json and should return an array of addons that are supported by our Open-Realty version
     *
     * This test should be split up into multiple test
     *
     * @return void
     */
    public function test_ajax_show_store_addons(): void
    {
        $GLOBALS['config']['version'] = '3.4.0';
        $manager = new addon_manager();
        $data = '{
        "version": "https://jsonfeed.org/version/1",
        "user_comment": "Open-Realty Addons",
        "title": "Open-Realty Official Addons",
        "description": "Open-Realty Official Addons List",
        "home_page_url": "https://www.open-realty.org",
        "feed_url": "https://www.open-realty.org/addons.json",
        "author": {
            "name": "Ryan Bonham"
        },
        "items": [
            {
            "title": "TransparentRETS",
            "author": "Ryan Bonham",
            "description": "TransparentRETS™ is a import tool, designed to import raw RETS listing data and photos from a Multiple Listing Service (MLS) RETS server directly into a Open-Realty listing database.\n",
            "homepage": "https://gitlab.com/appsbytherealryanbonham/transparentrets",
            "docs": "https://docs.open-realty.org/nav.addons/01.transaprentRETS/",
            "folder": "transaprentRETS",
            "versions": [
                {
                "version": "2.3.0-beta.2",
                "date": "2021-02-08T00:00:00.000Z",
                "stability": "prerelease",
                "download_url": "https://gitlab.com/appsbytherealryanbonham/transparentrets/-/package_files/7002153/download",
                "min_compatibility": "3.4.0-beta.1",
                "max_compatibility": null
                },
                {
                "version": "2.3.0-beta.1",
                "date": "2021-02-08T00:00:00.000Z",
                "stability": "prerelease",
                "download_url": "https://gitlab.com/appsbytherealryanbonham/transparentrets/-/package_files/7002153/download",
                "min_compatibility": "3.4.0-beta.1",
                "max_compatibility": null
                }
            ]
            },
            {
                "title": "TransparentMAPS",
                "author": "Ryan Bonham",
                "description": "TransparentMAPS is google maps addon.\n",
                "homepage": "https://gitlab.com/appsbytherealryanbonham/transparentmaps",
                "docs": "https://docs.open-realty.org/nav.addons/02.transparentMAPS/",
                "folder": "transparentmaps",
                "versions": [
                    {
                        "version": "2.2.20",
                        "date": "2021-02-08T00:00:00.000Z",
                        "stability": "prerelease",
                        "download_url": "https://gitlab.com/appsbytherealryanbonham/transparentrets/-/package_files/700afasd153/download",
                        "min_compatibility": "3.3.0",
                        "max_compatibility": "3.3.10"
                    },
                    {
                    "version": "3.0.0-beta.1",
                    "date": "2021-02-08T00:00:00.000Z",
                    "stability": "prerelease",
                    "download_url": "https://gitlab.com/appsbytherealryanbonham/transparentrets/-/package_files/70afdaf53/download",
                    "min_compatibility": "4.0.0",
                    "max_compatibility": "4.1.0"
                    },
                    {
                    "version": "2.3.0-beta.1",
                    "date": "2021-02-08T00:00:00.000Z",
                    "stability": "prerelease",
                    "download_url": "https://gitlab.com/appsbytherealryanbonham/transparentrets/-/package_files/70afdaf53/download",
                    "min_compatibility": "3.4.0-beta.1",
                    "max_compatibility": "4.0.0"
                    }
                ]
                }
        ]
        }';
        $expected[] = (object)[
            'title' => "TransparentRETS",
            'author' => "Ryan Bonham",
            'homepage' => "https://gitlab.com/appsbytherealryanbonham/transparentrets",
            'docs' => "https://docs.open-realty.org/nav.addons/01.transaprentRETS/",
            'folder' => "transaprentRETS",
            'version' => '2.3.0-beta.2',
            'download_url' => 'https://gitlab.com/appsbytherealryanbonham/transparentrets/-/package_files/7002153/download',
            'stability' => 'prerelease',
            'min_compatibility' => '3.4.0-beta.1',
            'max_compatibility' => '',
            
        ];
        $expected[] = (object)[
            'title' => "TransparentMAPS",
            'author' => "Ryan Bonham",
            'homepage' => "https://gitlab.com/appsbytherealryanbonham/transparentmaps",
            'docs' => "https://docs.open-realty.org/nav.addons/02.transparentMAPS/",
            'folder' => "transparentmaps",
            'version' => '2.3.0-beta.1',
            'download_url' => 'https://gitlab.com/appsbytherealryanbonham/transparentrets/-/package_files/70afdaf53/download',
            'stability' => 'prerelease',
            'min_compatibility' => '3.4.0-beta.1',
            'max_compatibility' => '4.0.0',
            
        ];
        $results = $this->invokeMethod($manager, 'parse_store_response', array($data));
        $this->assertEquals(
            $expected,
            $results
        );
        unset($config);
    }
}
