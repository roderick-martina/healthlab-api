<?php

namespace Tests\Feature\CustomFields;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use App\User;
use App\Models\Patient;
use App\Models\CustomField;

class PatientCustomFieldTest extends TestCase
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
    public function create_patient_custom_field()
    {
        $this->withoutExceptionHandling();
        $customField = factory(CustomField::class)->create([
            'user_id' => $this->user->id
        ]);

        $patient = factory(Patient::class)->create();
        $response = $this->json('POST', 'api/patients/customfields', [
            'patient_id' => $patient->id,
            'custom_field_id' => $customField->id,
            'value' => 'dit is een test'
        ]);

        $response
            ->assertStatus(201);

    }
}
