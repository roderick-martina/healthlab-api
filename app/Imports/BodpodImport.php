<?php

namespace App\Imports;

use App\Models\Bodpod;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\User;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Mockery\CountValidator\Exception;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class BodpodImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    const batchSizeAndChuckSize = 300;
    const batchSize = 300;
    const chunkSize = 300;
    // private $user;
    public function __construct()
    {
        // $this->user = $user;
    }

    /**
     * Removes backslash (/) from date string.
     *
     * @param String $date
     *
     * @return String
     */
    protected function normalizeDate($date)
    {
        if (strpos($date, '/')) {
            $date = str_replace('/', '-', $date);
        }
        return $date;
    }

    protected function normalizeValue($value)
    {
        if (strpos($value, ',')) {
            $value = str_replace(',', '.', $value);
        }
        return $value;
    }

    /**
     * create date
     *
     * @param String $date
     * @param String $format
     *
     * @return Carbon/Carbon/object
     */
    protected function createDate($date, $format)
    {
        $normalizedDate = $this->normalizeDate($date);
        return Carbon::createFromFormat($format, $normalizedDate);
    }

    protected function getDate($date, $format)
    {
        try {
            return $this->createDate($date, $format);
        } catch (\Exception $e) {
            return Date::excelToDateTimeObject($date);
        } catch (\exception $e) {
            dd('asd');
        }
    }

    protected function valueIsNull($value)
    {
        if ($value == 'NA') {
            return null;
        }
        return $value;
    }

    protected function resolveComment($comment)
    {
        if (str_contains($comment, ';')) {
            return explode(';', $comment);
        } else if ($comment == null) {
            return null;
        } else {
            return array(null, $comment);
        }
    }

    protected function validPatientIdentifier($id)
    {
        if(preg_match("/^20[0-9]{2}[0-9]{4}$/", $id) != 0){
            return (int) $id;
        } else {
            return null;
        }
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $format = 'm-d-Y h:i:s a';

        // skips duplicate rows
        if (Bodpod::where('test_no', $row['test_no'])->first()) {
            return null;
        }

        $resolvedCommentValue = $this->resolveComment($row['comments']);
        $researchProject = $resolvedCommentValue[0];
        $comment = $resolvedCommentValue[1];
        
        $bodpodIdentifier = $this->validPatientIdentifier($row['id_1']);
        // dd($bodpodIdentifier);

        if ($bodpodIdentifier != null) {
            if ($patient = patient::where('identifier', $bodpodIdentifier)->first()) {

            } else {
                $patient = Patient::create([
                    // 'user_id' => $this->user->id,
                    'identifier' => $bodpodIdentifier,
                    'valid_identifier' => true,
                    'research_project' => $researchProject,
                    'gender' => $row['gender'],
                    // 'date_of_birth' => $row['age']
                ]);
            }
        } else {
            $patient = null;
        }

        return new Bodpod([
            // 'user_id' => $this->user->id,
            'identifier' => $bodpodIdentifier,
            'patient_id' => $patient != null ? $patient->id : null,
            'test_date' => $this->getDate($row['test_date'], $format),
            'age' => $row['age'],
            'gender' => $row['gender'],
            'height_cm' => $row['height_cm'],
            'height_in' => $row['height_in'],
            'id_1' => $row['id_1'],
            'id_2' => $row['id_2'],
            'ethnicity' => $row['ethnicity'],
            'operator' => $row['operator'],
            'test_no' => $row['test_no'],
            'density_model' => $row['density_model'],
            'tgv_model' => $row['tgv_model'],
            'fat_percentage' => $row['fat'],
            'ffm_percentage' => $row['ffm'],
            'fat_mass_kg' => $row['fat_mass_kg'],
            'fat_mass_lb' => $row['fat_mass_lb'],
            'fat_free_mass_kg' => $row['fat_free_mass_kg'],
            'fat_free_mass_lb' => $row['fat_free_mass_lb'],
            'body_mass_kg' => $row['body_mass_kg'],
            'body_mass_lb' => $row['body_mass_lb'],
            'estimate_rmr_kcal_day' => $this->valueIsNull($row['est_rmr_kcalday']),
            'estimate_tee_kcal_day' => $this->valueIsNull($row['est_tee_kcalday']),
            'activity_level' => $row['activity_level'],
            'body_volume' => $row['body_volume'],
            'bd_kg_l' => $row['bd_kgl'],
            'volume1_l' => $row['volume1_l'],
            'volume2_l' => $row['volume2_l'],
            'volume3_l' => $row['volume3_l'],
            'dfm_kg_l' => $this->valueIsNull($row['dfm_kgl']),
            'dffm_kg_l' => $this->valueIsNull($row['dffm_kgl']),
            'tgv_l' => $row['tgv_l'],
            'predicted_tgv_l' => $row['predicted_tgv_l'],
            'bsa_cm2' => $row['bsa_cm2'],
            'comments' => $comment
        ]);
    }

    public function batchSize() : int
    {
        return static::batchSizeAndChuckSize;
    }

    public function chunkSize() : int
    {
        return static::batchSizeAndChuckSize;
    }
}