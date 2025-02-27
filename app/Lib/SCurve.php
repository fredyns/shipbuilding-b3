<?php

namespace App\Lib;

use App\Models\Shipbuilding;

class SCurve
{
    protected Shipbuilding $shipBuilding;
    protected $labels = [];
    protected $datasetPlan = [];
    protected $datasetProgress = [];

    public function __construct(Shipbuilding $shipBuilding)
    {
        $this->shipBuilding = $shipBuilding;
    }

    protected function generateData()
    {
        foreach ($this->shipBuilding->weeklyReports as $weeklyReport) {
            $this->labels[] = $weeklyReport->week;
            $this->datasetPlan[] = $weeklyReport->planned_progress;
            $this->datasetProgress[] = $weeklyReport->actual_progress;
        }
    }

    public function getLabels()
    {
        if (empty($this->labels)) {
            $this->generateData();
        }
        return json_encode($this->labels);
    }

    public function getDatasetPlan()
    {
        if (empty($this->datasetPlan)) {
            $this->generateData();
        }
        return json_encode($this->datasetPlan);
    }

    public function getDatasetProgress()
    {
        if (empty($this->datasetProgress)) {
            $this->generateData();
        }
        return json_encode($this->datasetProgress);
    }

}
