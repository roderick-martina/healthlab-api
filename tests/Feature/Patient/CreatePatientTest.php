<?php

namespace Tests\Feature\Patient;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Patient;
use Laravel\Passport\Passport;
use App\User;

class CreatePatientTest extends TestCase
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
    public function user_can_create_patient()
    {
        $identifier = 'test-1234-99-2018';
        $params = [
            'identifier' => $identifier
        ];

        $response = $this->json('post', 'api/patients', $params);
        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'identifier' => $identifier
            ]);
    }
    /** @test */
    public function patient_identifier_can_not_be_empty()
    {
        $identifier = '';

        $params = [
            'identifier' => $identifier
        ];

        $response = $this->json('post', 'api/patients', $params);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'identifier'
            ]);
    }
    /** @test */
    public function patient_identifier_has_to_be_unique()
    {
        $identifier = 'test-1234-99-2018';
        $patient = factory(Patient::class)->create([
            'user_id' =>  factory(User::class)->create(),
            'identifier' =>  $identifier,
        ]);
        $params = [
            'identifier' => $identifier
        ];

        $response = $this->json('post', 'api/patients', $params);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'identifier'
            ]);
    }
}
