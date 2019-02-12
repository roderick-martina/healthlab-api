<?php

namespace Tests\Feature\Patient;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Patient;
use Laravel\Passport\Passport;
use App\User;

class DeletePatient extends TestCase
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
    public function user_can_delete_user()
    {
        $patient = factory(Patient::class)->create();

        $response = $this->json('delete', "api/patients/{$patient->id}");

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'identifier' => "{$patient->identifier}"
            ]);

        $deletedPatient = Patient::find($patient->id);

        $this->assertNull($deletedPatient);
    }
}
