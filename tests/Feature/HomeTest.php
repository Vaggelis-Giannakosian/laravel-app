<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
 * A basic feature test example.
 *
 * @return void
 */
    public function testHomePageIsWorkingCorrectly()
    {
        $response = $this->get('/');
        $response->assertSeeText('Welcome to Laravel!');
        $response->assertSeeText('This is the content of the main page!');
        $response->assertSeeText('Laravel Blog');
        $response->assertStatus(200);
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testContactPageIsWorkingCorrectly()
    {
        $response = $this->get('/contact');
        $response->assertSeeText('Contact');
        $response->assertSeeText('This is the contact page');
        $response->assertStatus(200);
    }
}
