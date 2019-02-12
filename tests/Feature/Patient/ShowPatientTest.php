<?php

namespace Tests\Feature\Patient;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Patient;
use Laravel\Passport\Passport;
use App\User;
use App\Models\CustomField;
use App\Http\Resources\CustomFieldResource;

class ShowPatientTest extends TestCase
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
    public function show_all_users()
    {
        $patients = factory(Patient::class, 3)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->json('get', 'api/patients');

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'identifier' => $patients[0]->identifier,
                'identifier' => $patients[1]->identifier,
                'identifier' => $patients[2]->identifier,
            ]);
    }
    /** @test */
    public function get_specefic_patient()
    {
        $patient = factory(Patient::class)->create();
 
        $response = $this->json('get', "api/patients/{$patient->id}");
 
        $response
             ->assertStatus(200)
             ->assertJsonFragment([
                 'identifier' => $patient->identifier,
             ]);
    }

    // /** @test */
    // public function get_custom_fields()
    // {
    //     $patient = factory(Patient::class)->create();
    //     $customFields = factory(CustomField::class)->create([
    //         'patient_id' => $patient->id
    //     ]);

    //     $response = $this->json('get', "api/patients/{$patient->id}");
    //     $response
    //         ->assertStatus(200)
    //         ->assertJsonFragment([
    //             'data'=> [
    //                 'custom_fields' => [new CustomFieldResource($customFields)]
    //             ]   
    //         ]);
        
    // }
}
