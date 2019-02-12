<?php

namespace Tests\Feature\Patient;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Patient;
use Laravel\Passport\Passport;
use App\User;

class EditPatientTest extends TestCase
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
    public function user_can_edit_patient_identifier()
    {
        $this->withoutExceptionHandling();
        $patient = factory(Patient::class)->create();

        $identifier = 'test-0000-xx-2018';

        $params = [
            'identifier' => $identifier
        ];

        $response = $this->json('patch', "api/patients/{$patient->id}", $params);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $patient->id,
                'identifier' => $identifier
            ]);
    }
    /** @test */
    public function user_can_not_pass_empty_identifier_field()
    {
        $patient = factory(Patient::class)->create();

        $identifier = ' ';

        $params = [
            'identifier' => $identifier
        ];

        $response = $this->json('patch', "api/patients/{$patient->id}", $params);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'identifier'
            ]);
    }
}
