<?php

namespace App\Imports;

use App\Models\Mbca;
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
use Illuminate\Validation\Rule;

class MbcaImport implements ToModel, WithCustomCsvSettings, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    const batchSizeAndChuckSize = 300;
    const batchSize = 300;
    const chunkSize = 300;

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
        return carbon::createFromFormat($format, $normalizedDate);
    }

    protected function getDate($date, $format, $altFormat)
    {
        try {
            return $this->createDate($date, $format);
        } catch (\Exception $e) {
            return $this->createDate($date, $altFormat);
        } catch (\exception $e) {
            dd('asd');
        }
    }

    protected function getBirthDate($date, $format, $altFormat)
    {
        if (strpos($date, '/')) {
            $date = str_replace('/', '-', $date);
            return $this->createDate($date, $altFormat);
        }
        return $this->createDate($date, $format);
    }

    protected function valueIsNull($value)
    {
        $value = $this->normalizeValue($value);
        if ($value == '-') {
            return null;
        }
        return $value;
    }
    protected function getAge($value)
    {
        return Carbon::createFromFormat('Y-m-d', $value)->age;
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
            return true;
        } else {
            return false;
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
        $altFormat = 'd-m-y H:i';
        $birthday = $this->getBirthDate($row['date_of_birth'], 'd-m-y', 'm-d-Y')->toDateString();

        // skips row that no value but -
        if ($row['bmi_value'] == '-') {
            return null;
        }

        $resolvedCommentValue = $this->resolveComment($row['comment']);
        $researchProject = $resolvedCommentValue[0];
        $comment = $resolvedCommentValue[1];

        if ($patient = patient::where('identifier', $row['id'])->first()) {
            
        } else {
            $patient = Patient::create([
                // 'user_id' => $this->user->id,
                'identifier' => $row['id'],
                'valid_identifier' => $this->validPatientIdentifier($row['id']),
                'gender' => $row['gender'],
                'research_project' => $researchProject,
                'date_of_birth' => $this->getBirthDate($row['date_of_birth'], 'd-m-y', 'm-d-Y')->toDateString()
            ]);
        }

        

        $bmi_value = str_replace(',', '.', $row['bmi_value']);
        $timestamp = $this->getDate($row['timestamp'], $format, $altFormat);

        $duplicateResult = Mbca::where([
            ['bmi_value', $bmi_value],
            ['timestamp', $timestamp]
        ])->first();

        if ($duplicateResult) {
            return null;
        }
        
        

        $mbca = new Mbca([
            'identifier' => $row['id'],
            // 'user_id' => $this->user->id,
            'patient_id' => $patient->id,
            'gender' => $row['gender'],
            'doctor' => $row['doctor'],
            'date_of_birth' => $this->getBirthDate($row['date_of_birth'], 'd-m-y', 'm-d-Y')->toDateString(),
            'age' => (int) $this->getAge($birthday),
            'created' => $this->getDate($row['created'], $format, $altFormat),
            'comment' => $comment,
            'ethnic' => $row['ethnic'],
            'last_modified' => $this->getDate($row['last_modified'], $format, $altFormat),
            // 'education' => $education,
            'timestamp' => $timestamp,
            'bmi_value' => $this->valueIsNull($row['bmi_value']),
            'sds_bmi_value' => $this->valueIsNull($row['sds_bmi_value']),
            'percentile_bmi_value' => (int) $this->valueIsNull($row['percentile_bmi_value']),
            'relative_fat_mass_value' => $this->valueIsNull($row['relative_fat_mass_value']),
            'absolute_fat_mass_value' => $this->valueIsNull($row['absolute_fat_mass_value']),
            'fat_free_mass_value' => $this->valueIsNull($row['fat_free_mass_value']),
            'skeletal_muscle_mass_value' => $this->valueIsNull($row['skeletal_muscle_mass_value']),
            'smm_torso_value' => $this->valueIsNull($row['smm_torso_value']),
            'smm_rl_value' => $this->valueIsNull($row['smm_rl_value']),
            'smm_ll_value' => $this->valueIsNull($row['smm_ll_value']),
            'smm_la_value' => $this->valueIsNull($row['smm_la_value']),
            'smm_ra_value' => $this->valueIsNull($row['smm_ra_value']),
            'total_body_water_value' => $this->valueIsNull($row['total_body_water_value']),
            'extracellular_water_value' => $this->valueIsNull($row['extracellular_water_value']),

            'waist_circumference_value' => $this->valueIsNull($row['waist_circumference_value']),
            'sds_weight_value' => $this->valueIsNull($row['sds_weight_value']),
            'weight_value' => $this->valueIsNull($row['weight_value']),
            'percentile_weight_value' => (int) $this->valueIsNull($row['percentile_weight_value']),
            'sds_height_value' => $this->valueIsNull($row['sds_height_value']),
            'height_value' => $this->valueIsNull($row['height_value']),
            'percentile_height_value' => (int) $this->valueIsNull($row['percentile_height_value']),
            'total_energy_expenditure_value' => $this->valueIsNull($row['total_energy_expenditure_value']),
            'resting_energy_expenditure_value' => $this->valueIsNull($row['resting_energy_expenditure_value']),
            'ffmi_value' => $this->valueIsNull($row['ffmi_value']),
            'fmi_value' => $this->valueIsNull($row['fmi_value']),
            'z_ffmi_value' => $this->valueIsNull($row['zffmi_value']),
            'z_fmi_value' => $this->valueIsNull($row['zfmi_value']),
            'bioelectric_impedance_vector_analysis_r_value' => $this->valueIsNull($row['bioelectric_impedance_vector_analysis_r_value']),
            'bioelectric_impedance_vector_analysis_xc_value' => $this->valueIsNull($row['bioelectric_impedance_vector_analysis_xc_value']),
            'bioelectric_impedance_vector_analysis_zr_value' => $this->valueIsNull($row['bioelectric_impedance_vector_analysis_zr_value']),
            'bioelectric_impedance_vector_analysis_zxc_value' => $this->valueIsNull($row['bioelectric_impedance_vector_analysis_zxc_value']),
            'phaseangle_value' => $this->valueIsNull($row['phaseangle_value']),
            'sds_phaseangle_value' => $this->valueIsNull($row['sds_phaseangle_value']),
            'percentile_phaseangle_value' => (int) $this->valueIsNull($row['percentile_phaseangle_value']),
            'ecw_by_tbw_value' => (int) $this->valueIsNull($row['ecw_by_tbw_value']),
        ]);

        return $mbca;
    }

    public function getCsvSettings() : array
    {
        return [
            'delimiter' => ';'
        ];
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
