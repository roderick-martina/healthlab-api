<?php

namespace Tests\Feature\CustomFields;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use App\User;
use App\Models\Patient;

class CustomFieldTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp()
    {
        parent::setUp();
        $this->user = Passport::actingAs(
            factory(User::class)->create()
        );
    }
    
    /** @test */
    public function create_custom_field()
    {
        $this->withoutExceptionHandling();


        $field_name = 'Bodymass';
        
        $response = $this->json('POST', 'api/customfields', [
            'user_id' => $this->user->id,
            'field_name' => $field_name,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'message' => "CustomField: {$field_name} has been created."
            ]);
    }
}
