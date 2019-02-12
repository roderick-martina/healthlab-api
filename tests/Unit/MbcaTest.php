<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Mbca;
use Carbon\Carbon;
use App\Models\Patient;

class MbcaTest extends TestCase
{
    use RefreshDatabase;
    // /** @test */
    // public function normalize_date_with_backslash()
    // {
    //     $mbca = new Mbca();
    //     $result = $mbca->normalizeDate('5/16/1961');
    //     $this->assertEquals('5-16-1961', $result);
    // }
    // /** @test */
    // public function normalize_date_with_upperscore()
    // {
    //     $mbca = new Mbca();
    //     $result = $mbca->normalizeDate('5-16-1961');
    //     $this->assertEquals('5-16-1961', $result);
    // }
    /** @test */
    public function can_create_date()
    {
        $mbca = new Mbca();
        $result = $mbca->createDate('5-16-1961');
        $this->assertEquals('1962-04-05', $result);
    }
    /** @test */
    public function can_normalize_date()
    {
        $mbca = new Mbca();
        $result = $mbca->createDate('5/16/1961');
        $this->assertEquals('1962-04-05', $result);
    }
    /** @test */
    public function get_eduction_value_from_comment_field()
    {
        $mbca = new Mbca();

        $educationValue = 'HolaSSS';
        $commentValue = 'dit is een test comment field';
        $comment = "{$educationValue};{$commentValue}";
        $commentValues = $mbca->resolveComment($comment);

        if($commentValues instanceof Array){
            return;
        }
        $this->assertNotNull($commentValues);
        $this->assertEquals($educationValue,$commentValues[0]);
        $this->assertEquals($commentValue,$commentValues[1]);
    }

    /** @test */
    public function test()
    {
        $date = '5/16/1961';
        
        $patientId = factory(Patient::class)->create()->id;
        $mbca = new Mbca([
            'patient_id' => $patientId
        ]);

        $mbca->date_of_birth = $mbca->createDate($date);
       
        $mbca->save();
        dd($mbca);
    }
}
