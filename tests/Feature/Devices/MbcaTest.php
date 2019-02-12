<?php

namespace Tests\Feature\Devices;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Passport;
use App\User;

class MbcaTest extends TestCase
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
    public function user_can_import_csv_file()
    {
        $this->withExceptionHandling();
        // Storage::fake('files');
        $path = resource_path('exports/mbca.csv');
        $file = new UploadedFile($path, 'mbca.csv');

        $response = $this->json('POST', 'api/mbca', [
            'mbca' => $file
        ]);
        $this->assertNotEmpty($this->user->mbcaResults);

    }
}
