<?php


namespace App\APIServices;

use App\ActionData\OSAGOEpolis\ApplicationActionData;
use App\Models\ProductTariffConfiguration;
use Illuminate\Support\Facades\Http;

class OSAGOEpolisService
{
    public function calcPrice($product_id, $dictionary_item_ids) {
        $product_configurations = ProductTariffConfiguration::query()->whereHas('product_configuration_group', function ($query) use ($product_id) {
            $query->where('product_id', $product_id);
        })->whereIn('dictionary_item_id', $dictionary_item_ids)->get();

        $price = 1;

        foreach ($product_configurations as $p) {
            $price *= $p->value;
        }

        return $price;
    }


    public function getVehicleData($tech_pass_series, $tech_pass_number, $auto_number) {
        $url = 'http://example.com';
        $response = Http::post($url, [
            'tech_pass_series' => $tech_pass_series,
            'tech_pass_number' => $tech_pass_number,
            'auto_number' => $auto_number
        ]);

        if($response->ok()) {
            return [
                'tech_pass_issue_date' => $response['tech_pass_issue_date'],
                'model_custom_name' => $response['modelCustomName'],
                'engine_number' => $response['engineNumber'],
                "type_id" => $response['vehicleTypeId'],
                "issue_year" => $response['vehicleIssueYear'],
                "body_number" => $response['vehicleBodyNumber'],
                "first_name"=> $response['ownerFirstName'],
                "last_name"=> $response['ownerLastName'],
                "middle_name"=> $response['ownerMiddleName'],
                "adress"=> $response['ownerAdress'],
                "pinfl"=> $response['ownerPinfl']
            ];
        }
    }


    public function sendData(ApplicationActionData $action_data) {
        $applicant_data = [
            "person" => [
                "passportData" => [
                    "pinfl" => $action_data->applicant->pinfl,
                    "seria" => $action_data->applicant->pass_series,
                    "number" => $action_data->applicant->pass_number,
                    "issuedBy" => $action_data->applicant->pass_issues_by,



                    "issueDate" => $action_data->applicant->pass_issue_date
                ],
                "fullName" => [
                    "firstname" => $action_data->applicant->firstname,
                    "lastname" => $action_data->applicant->lastname,
                    "middlename" => $action_data->applicant->middlename
                ],
                "phoneNumber" => $action_data->applicant->phone_number,
                "gender" => $action_data->applicant->gender,
                "birthDate" => $action_data->applicant->birth_date,
                "regionId" => $action_data->applicant->region_id,
                "districtId" => $action_data->applicant->district_id
            ],
            "address" => $action_data->applicant->address,
            "email" => $action_data->applicant->email
        ];



        $owner_data = [
            "person" => [
                "passportData" => [
                    "pinfl" => $action_data->owner->pinfl,
                    "seria" => $action_data->owner->pass_series,
                    "number" => $action_data->owner->pass_number,
                    "issuedBy" => $action_data->owner->pass_issued_by,
                    "issueDate" => $action_data->owner->pass_issue_date
                ],
                "fullName" => [
                    "firstname" => $action_data->owner->firstname,
                    "lastname" => $action_data->owner->lastname,
                    "middlename" => $action_data->owner->middlename
                ]
            ],
            "applicantIsOwner" => $action_data->owner->applicant_is_owner
        ];

        $drivers = [];

        foreach($action_data->drivers as $driver) {
            $drivers[] = [
                [
                    "passportData" => [
                        "pinfl" => $driver->pinfl,
                        "seria" => $driver->pass_series,
                        "number" => $driver->pass_number,
                        "issuedBy" => $driver->pass_issued_by,
                        "issueDate" => $driver->pass_issue_date
                    ],
                    "fullName" => [
                        "firstname" => $driver->firstname,
                        "lastname" => $driver->lastname,
                        "middlename" => $driver->middlename
                    ],
                    "licenseNumber" => $driver->license_number,
                    "licenseSeria" => $driver->license_series,
                    "relative" => $driver->relative,
                    "birthDate" => $driver->birth_date,
                    "licenseIssueDate" => $driver->license_issue_date
                ]
            ];
        }

        $data = [
            "applicant" => $applicant_data,
            "owner" => $owner_data,
            "details" => [
                "issueDate" => $action_data->details->issue_date,
                "startDate" => $action_data->details->start_date,
                "endDate" => $action_data->details->end_date,
                "driverNumberRestriction" => $action_data->details->driver_number_destriction,
            ],
            "cost" => [
                "discountId" => $action_data->cost->discount_id,
                "discountSum" => $action_data->cost->discount_sum,
                "insurancePremium" => $action_data->cost->insurance_premium,
                "insurancePremiumPaidToInsurer" => $action_data->cost->insurance_premium_paid_to_insurer,
                "sumInsured" => $action_data->cost->sum_insured,
                "contractTermConclusionId" => $action_data->cost->contract_term_conclusion_id,



                "useTerritoryId" => $action_data->cost->use_territory_id,
                "commission" => $action_data->cost->comission,
                "seasonalInsuranceId" => $action_data->cost->seasonal_insurance_id
            ],
            "vehicle" => [
                "techPassport" => [
                    "number" => $action_data->vehicle->tech_pass_number,
                    "seria" => $action_data->vehicle->tech_pass_series,
                    "issueDate" => $action_data->vehicle->tech_pass_issue_date
                ],
                "modelCustomName" => $action_data->vehicle->model_custom_name,
                "engineNumber" => $action_data->vehicle->engine_number,
                "typeId" => $action_data->vehicle->type_id,
                "issueYear" => $action_data->vehicle->issue_year,
                "govNumber" => $action_data->vehicle->gov_number,
                "bodyNumber" => $action_data->vehicle->body_number,
                "regionId" => $action_data->vehicle->region_id
            ],
            'drivers' => $drivers
        ];

        $url = 'epolicy/create';
        $response = Http::post($url, $data);

        if($response->ok()) {
            return [
                'uuid' => $response['uuid'],
                'anketa_id' => $response['anketa_id'],
            ];
        }
    }
}
