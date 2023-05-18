<?php

namespace App\ActionData\OSAGOEpolis;

use App\ActionData\ActionDataBase;

class ApplicationActionData extends ActionDataBase
{
    public $applicant;
    public $owner;
    public $cost;
    public $details;
    public $vehicle;
    public $drivers = [];

    public function setApplicant(ApplicantActionData $data){
        $this->applicant = $data;
    }

    public function setOwner(ownerActionData $data){
        $this->owner = $data;
    }

    public function setCost(CostActionData $data){
        $this->cost = $data;
    }

    public function setDetails(DetailsActionData $data){
        $this->details = $data;
    }

    public function setVehicle(VehicleActionData $data){
        $this->vehicle = $data;
    }

    /**
     * @param DriverActionData[] $drivers
     */
    public function setDrivers($drivers){
        $this->drivers = $drivers;
    }

}
