<?php

namespace App\Actions\DailyReport;

use App\Models\DailyReport;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;

class DocxTemplate
{
    const TEMPLATE = 'templates/daily-report-bag.docx';
    protected DailyReport $dailyReport;
    protected TemplateProcessor $template;

    public function __construct(DailyReport $dailyReport)
    {
        $this->dailyReport = $dailyReport;
        $this->phpWord = new PhpWord();
    }

    public function run()
    {
        $this->template = new TemplateProcessor(base_path(self::TEMPLATE));

        $values = [
            'date' => $this->dailyReport->date->translatedFormat('d F Y'),
            'projectTitle' => htmlspecialchars('Jasa Konsultan Pengawas Pembangunan 4 & Set Tug Barge'),
            'location' => '-',
            'owner' => '-',
            'vesselName' => htmlspecialchars($this->dailyReport->shipbuilding->name),
            'morningWeather' => htmlspecialchars(optional($this->dailyReport->morningWeather)->name ?? '-'),
            'morningHumidity' => htmlspecialchars(optional($this->dailyReport->morningHumidity)->name ?? '-'),
            'middayWeather' => htmlspecialchars(optional($this->dailyReport->middayWeather)->name ?? '-'),
            'middayHumidity' => htmlspecialchars(optional($this->dailyReport->middayHumidity)->name ?? '-'),
            'afternoonWeather' => htmlspecialchars(optional($this->dailyReport->afternoonWeather)->name ?? '-'),
            'afternoonHumidity' => htmlspecialchars(optional($this->dailyReport->afternoonHumidity)->name ?? '-'),
            'temperature' => $this->dailyReport->temperature,
        ];
        $this->template->setValues($values);
        $this->template->cloneRowAndSetValues('pNo', iterator_to_array($this->personelData()));
        $this->template->cloneRowAndSetValues('eNo', iterator_to_array($this->equipmentData()));
        $this->template->cloneRowAndSetValues('mNo', iterator_to_array($this->materialData()));
        $this->template->cloneRowAndSetValues('aNo', iterator_to_array($this->activityData()));


        return $this->template;
    }

    protected function personelData()
    {
        if (!$this->dailyReport->dailyPersonnels()->exists()) {
            yield [
                'pNo' => '1',
                'personelRole' => '-',
                'personelPresent' => '-',
                'personelRemark' => '-',
            ];
            return;
        }

        $no = 0;
        foreach ($this->dailyReport->dailyPersonnels as $personel) {
            yield [
                'pNo' => ++$no,
                'personelRole' => htmlspecialchars($personel->role),
                'personelPresent' => $personel->present ? 'Ada' : 'Tidak Ada',
                'personelRemark' => htmlspecialchars($personel->description),
            ];
        }
    }

    protected function equipmentData()
    {
        if (!$this->dailyReport->dailyEquipments()->exists()) {
            yield [
                'eNo' => '1',
                'equipmentName' => '-',
                'equipmentQty' => '-',
                'equipmentRemark' => '-',
            ];
            return;
        }

        $no = 0;
        foreach ($this->dailyReport->dailyEquipments as $equipment) {
            yield [
                'eNo' => ++$no,
                'equipmentName' => htmlspecialchars($equipment->name),
                'equipmentQty' => htmlspecialchars($equipment->quantity),
                'equipmentRemark' => htmlspecialchars($equipment->remark),
            ];
        }
    }

    protected function materialData()
    {
        if (!$this->dailyReport->dailyMaterials()->exists()) {
            yield [
                'mNo' => '1',
                'materialName' => '-',
                'materialQty' => '-',
                'materialRemark' => '-',
            ];
            return;
        }

        $no = 0;
        foreach ($this->dailyReport->dailyMaterials as $material) {
            yield [
                'mNo' => ++$no,
                'materialName' => htmlspecialchars($material->name),
                'materialQty' => htmlspecialchars($material->quantity),
                'materialRemark' => htmlspecialchars($material->remark),
            ];
        }
    }

    protected function activityData()
    {
        if (!$this->dailyReport->dailyActivities()->exists()) {
            yield [
                'aNo' => '1',
                'activityName' => '-',
                'activityPIC' => '-',
            ];
            return;
        }

        $no = 0;
        foreach ($this->dailyReport->dailyActivities as $activity) {
            yield [
                'aNo' => ++$no,
                'activityName' => htmlspecialchars($activity->name),
                'activityPIC' => htmlspecialchars($activity->pic),
            ];
        }
    }

    protected function writeDocumentations()
    {
        if (!$this->dailyReport->dailyDocumentations()->exists()) {
            $data = [
                'dNo' => '1',
                'documentationImage' => '-',
                'documentationRemark' => '-',
            ];
            $this->template->setValues($data);
        }

        $this->template->cloneRow('dNo', $this->dailyReport->dailyDocumentations()->count());

        $i = 0;
        foreach ($this->dailyReport->dailyDocumentations as $documentation) {
            $data = [
                'dNo' => ++$i,
                'documentationRemark' => htmlspecialchars($documentation->remark),
            ];
            $this->template->setValues($data);

            $imgPath = \Storage::url($documentation->image);
            $this->template->setImageValue('documentationImage#' . $i, $imgPath, 1);

        }

    }
}
