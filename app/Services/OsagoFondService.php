<?php

namespace App\Services;

use App\ActionData\Client\ClientActionData;
use App\ActionData\Client\IndividualClientActionData;
use App\ActionData\OSAGOEpolis\CostActionData;
use App\ActionData\OSAGOEpolis\DetailsActionData;
use App\ActionData\OSAGOEpolis\DriverActionData;
use App\ActionData\OSAGOEpolis\ObjectActionData;
use App\ActionData\OSAGOEpolis\OrganizationActionData;
use App\ActionData\OSAGOEpolis\OsagoAnnulmentActionData;
use App\ActionData\OSAGOEpolis\OwnerActionData;
use App\ActionData\OSAGOEpolis\PersonActionData;
use App\ActionData\OSAGOEpolis\PinflActionData;
use App\ActionData\OSAGOEpolis\ProvidedDiscountActionData;
use App\ActionData\OSAGOEpolis\VehicleActionData;
use App\Models\ClientContract;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Validation\ValidationException;

class OsagoFondService
{
    /**
     * @param VehicleActionData $actionData
     * @return array
     * @throws Exception
     */
    public function getVehicleInformation(VehicleActionData $actionData): array
    {
        $key = "cache__$actionData->techPassportNumber|$actionData->techPassportSeria|$actionData->govNumber";
        return cache()->remember($key, now()->addMonth(), function () use ($actionData) {

            return $this->request($actionData->all(), 'provider/vehicle');
        });
    }


    /**
     * @param PinflActionData $actionData
     * @return array
     * @throws Exception
     */
    public function getPinflInformation(PinflActionData $actionData): array
    {
        $key = "cache__{$actionData->pinfl}_{$actionData->passportNumber}_{$actionData->passportSeries}";
        return cache()->remember($key, now()->addMonth(), function () use ($actionData) {

            return $this->request($actionData->all(), 'provider/pinfl');
        }
        );
    }

    /**
     * @param PinflActionData $actionData
     * @return mixed
     * @throws Exception
     */
    public function isPensioner(PinflActionData $actionData): array
    {
        $key = "cache__{$actionData->passportNumber}_{$actionData->pinfl}_{$actionData->passportSeries}";
        return cache()->remember($key, now()->addMonth(), function () use ($actionData) {

            return $this->request($actionData->all(), 'provider/is-pensioner');
        }
        );
    }

    /**
     * @param ProvidedDiscountActionData $actionData
     * @return array
     * @throws Exception
     */
    public function providedDiscount(ProvidedDiscountActionData $actionData): array
    {
        $key = "cache__$actionData->pinfl|$actionData->govNumber";
        return cache()->remember($key, now()->addMonth(), function () use ($actionData) {
            return $this->request($actionData->all(), 'provider/provided-discounts');
        }
        );
    }

    /**
     * @param PersonActionData $actionData
     * @return array
     * @throws Exception
     */
    public function getPersonInformation(PersonActionData $actionData): array
    {
        $key = "cache__$actionData->passport_series|$actionData->passport_number|$actionData->birthDate";

        return cache()->remember($key, now()->addMonth(), function () use ($actionData) {
            $result = $this->request([
                'passportSeries' => $actionData->passport_series,
                'passportNumber' => $actionData->passport_number,
                'birthDate' => $actionData->birthDate,
                'isConsent' => 'Y',
            ], 'provider/passport-birth-date');

            if ($result) {
                return [
                    "pinfl" => $result["pinfl"],
                    "last_name" => $result["lastNameLatin"],
                    "first_name" => $result["firstNameLatin"],
                    "middle_name" => $result["middleNameLatin"],
                    "birthday" => $result["birthDate"],
                    "gender" => $result["gender"],
                    "passport_issued_by" => $result["issuedBy"],
                    "passport_issue_date" => $result["startDate"],
                    "region_id" => $result["regionId"],
                    "district_id" => $result["districtId"],
                    "address" => $result["address"]
                ];
            } else {
                return [];
            }
        });
    }


    /**
     * @param OrganizationActionData $actionData
     * @return array
     * @throws GuzzleException
     */
    public function getOrganizationInformation(OrganizationActionData $actionData): array
    {
        return $this->request([
            'inn' => $actionData->inn,

        ], 'provider/inn');
    }

    /**
     * @param ClientActionData $client_action_data
     * @param OwnerActionData $owner_action_data
     * @param DriverActionData[] $drivers_action_data
     * @param DetailsActionData $details_action_data
     * @param CostActionData $cost_action_data
     * @param ObjectActionData $object_action_data
     * @return array
     * @throws BindingResolutionException
     * @throws GuzzleException
     * @throws ValidationException
     * @throws Exception
     */
    public function sendData(
        ClientActionData  $client_action_data,
        OwnerActionData   $owner_action_data,
        array             $drivers_action_data,
        DetailsActionData $details_action_data,
        CostActionData    $cost_action_data,
        ObjectActionData  $object_action_data
    ): array
    {
        $individual_client_action_data = IndividualClientActionData::createFromArray($client_action_data->individual);
        $individual_client_action_data->validate();

        if ($owner_action_data->inn) {
            $owner_data = [
                "applicantIsOwner" => $owner_action_data->applicant_is_owner
            ];

            if ($owner_action_data->applicant_is_owner == false) {
                $owner_data["organization"] = [
                    "inn" => $owner_action_data->inn,
                    "name" => $owner_action_data->name
                ];
            }
        } else {
            $owner_data = [
                "applicantIsOwner" => $owner_action_data->applicant_is_owner
            ];

            if ($owner_action_data->applicant_is_owner == false) {
                $owner_data["person"] = [
                    "passportData" => [
                        "pinfl" => $owner_action_data->pinfl,
                        "seria" => $owner_action_data->passport_series,
                        "number" => $owner_action_data->passport_number,
                        "issuedBy" => $owner_action_data->passport_issued_by,
                        "issueDate" => $owner_action_data->passport_issue_date
                    ],
                    "fullName" => [
                        "firstname" => $owner_action_data->first_name,
                        "lastname" => $owner_action_data->last_name,
                        "middlename" => $owner_action_data->middle_name

                    ],
                ];
            }
        }


        $applicant_data = [
            "person" => [
                "passportData" => [
                    "pinfl" => $individual_client_action_data->pinfl,
                    "seria" => $individual_client_action_data->passport_seria,
                    "number" => $individual_client_action_data->passport_number,
                    "issuedBy" => $individual_client_action_data->passport_issued_by,
                    "issueDate" => $individual_client_action_data->passport_issue_date
                ],
                "fullName" => [
                    "firstname" => $individual_client_action_data->first_name,
                    "lastname" => $individual_client_action_data->last_name,
                    "middlename" => $individual_client_action_data->middle_name

                ],
                "phoneNumber" => ltrim($client_action_data->phone, '+'),
                "gender" => $individual_client_action_data->gender,
                "birthDate" => $individual_client_action_data->birthday,
                "regionId" => $individual_client_action_data->region_id,
                "districtId" => $individual_client_action_data->district_id
            ],
            "address" => $client_action_data->address,
            "email" => ''
        ];

        $drivers = $drivers_action_data;
//        foreach($drivers_action_data as $driver) {
//            $drivers[] = [
//                "passportData" => [
//                    "pinfl" => $driver['passportData']['pinfl'],
//                    "seria" => $driver['passportData']['pinfl'],
//                    "number" => $driver['passportData']['pinfl'],
//                    "issuedBy" => $driver['passportData']['pinfl'],
//                    "issueDate" => $driver['passportData']['pinfl']
//                ],
//                "fullName" => [
//                    "firstname" => $driver->first_name,
//                    "lastname" => $driver->last_name,
//                    "middlename" => $driver->middle_name,
//                ],
//                "licenseNumber" => $driver->license_number,
//                "licenseSeria" => $driver->license_series,
//                "relative" => $driver->relative,
//                "birthDate" => $driver->birthday,
//                "licenseIssueDate" => $driver->license_issue_date
//            ];
//        }

        $data = [
            "applicant" => $applicant_data,
            "owner" => $owner_data,
            "details" => [
                "issueDate" => $details_action_data->issue_date,
                "startDate" => $details_action_data->start_date,
                "endDate" => $details_action_data->end_date,
                "driverNumberRestriction" => $details_action_data->driver_number_destriction,
                "specialNote" => $details_action_data->special_note,
                "insuredActivityType" => $details_action_data->insured_activity_type,
            ],
            "cost" => [
                "discountId" => $cost_action_data->discount_id,
                "discountSum" => $cost_action_data->discount_sum,
                "insurancePremium" => $cost_action_data->insurance_premium,
                "insurancePremiumPaidToInsurer" => $cost_action_data->insurance_premium_paidTo_insurer,
                "sumInsured" => $cost_action_data->sum_insured,
                "contractTermConclusionId" => $cost_action_data->contract_term_conclusion_id,
                "useTerritoryId" => $cost_action_data->use_territory_id,
                "commission" => $cost_action_data->commission,
                "seasonalInsuranceId" => $cost_action_data->seasonal_insurance_id
            ],
            "vehicle" => [
                "techPassport" => [
                    "number" => $object_action_data->techPassportSeria,
                    "seria" => $object_action_data->techPassportNumber,
                    "issueDate" => $object_action_data->techPassportIssueDate,
                ],
                "modelCustomName" => $object_action_data->modelName,
                "engineNumber" => $object_action_data->engineNumber,
                "typeId" => $object_action_data->vehicleTypeId,
                "issueYear" => $object_action_data->issueYear,
                "govNumber" => $object_action_data->govNumber,
                "bodyNumber" => $object_action_data->bodyNumber,
                "regionId" => $this->getVehicleRegionId($object_action_data->govNumber)
            ],
            'drivers' => $drivers

        ];
        return $this->request($data, 'epolicy/create');
    }

    /**
     * @param string $number
     * @return string
     * @throws Exception
     */
    public function getVehicleRegionId(string $number)
    {
        $region_code = substr($number, 0, 2);
        switch ($region_code) {
            case "01":
                return '10';
            case "10":
                return '11';
            case "20":
                return '12';
            case "25":
                return '13';
            case "30":
                return '14';
            case "40":
                return '15';
            case "50":
                return '16';
            case "60":
                return '17';
            case "70":
                return '18';
            case "75":
                return '19';
            case "80":
                return '20';
            case "85":
                return '21';
            case "90":
                return '22';
            case "95":
                return '23';
            default:
                throw new Exception("Wrong government number!");
        }
    }

    /**
     * @param ClientContract $contract
     * @return array
     * @throws GuzzleException
     */
    public function confirmPayment(
        ClientContract $contract): array
    {
        $result = $this->request([
            'insuranceFormUuid' => $contract->configurations['uuid'],
            'paymentDate' => $contract->invoice->payment->created_at->format('Y-m-d'),
            'insurancePremiumPaidToInsurer' => $contract->amount,
            'startDate' => date('Y-m-d', strtotime($contract->begin_date)),
            'endDate' => date('Y-m-d', strtotime($contract->end_date)),
        ], 'epolicy/confirm-payed');

        if ($result) {
            return [
                "seria" => $result["seria"],
                "number" => $result["number"]
            ];
        } else {
            return [];
        }
    }

    /**
     * @param OsagoAnnulmentActionData $annulment_action_data
     * @return array
     * @throws GuzzleException
     */
    public function annulment(
        OsagoAnnulmentActionData $annulment_action_data): array
    {
        $result = $this->request([
            'insuranceFormUuid' => $annulment_action_data->insuranceFormUuid,
            'refundAmount' => $annulment_action_data->refundAmount,
            'insurancePremium' => $annulment_action_data->insurancePremium,
            'terminationDate' => $annulment_action_data->terminationDate,
        ], 'epolicy/motion-annulment');

        if ($result) {
            return [
                "uuid" => $result["uuid"],
            ];
        } else {
            return [];
        }
    }

    /**
     * @param array $params
     * @return void
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function checkReliability(array $params)
    {
        $pensioner = data_get($params, 'pensioner');
        if (is_null($pensioner) or $pensioner == 0) {
            return;
        }

        if (data_get($params, 'pensioner') == 1) {
            $pinfl = PinflActionData::createFromArray([
                'passportSeries' => data_get($params, 'p_seria'),
                'passportNumber' => data_get($params, 'p_number'),
                'pinfl' => data_get($params, 'pinfl')
            ]);

            $response = $this->isPensioner($pinfl);

            if (data_get($response, 'data.isPensioner') == 0) {
                throw new Exception("Tur yoqol  Pensioner emassan");
            }
        }

        $provided = ProvidedDiscountActionData::createFromArray([
            'pinfl' => data_get($params, 'pinfl'),
            'govNumber' => data_get($params, 'gov_number')
        ]);

        $response = $this->providedDiscount($provided);

        if (empty(data_get($response, 'data.discounts'))) {
            throw new Exception("Tur yoqol  skidkadan  foydalanib bo'lgansan");
        }
    }

    /**
     * @param array $parameters
     * @param string $uri
     * @param string $method
     * @return array
     * @throws GuzzleException
     */
    private function request(array $parameters, string $uri, string $method = 'post'): array
    {
        $client = new Client([
            'base_uri' => config('app.osago_fond_endpoint')
        ]);
//        dd($parameters);

        $response = $client->request(strtoupper($method), $uri, [
            'json' => $parameters,
            'headers' => [
                'Authorization' => 'Bearer ' . config('app.osago_fond_token')
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['result'] ?? [];
    }


}
