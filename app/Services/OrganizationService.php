<?php

namespace App\Services;

use App\ActionData\Organization\AgentActionData;
use App\ActionData\Organization\AgentUpdateActionData;
use App\ActionData\Organization\FilialActionData;
use App\ActionData\Organization\OrganizationActionData;
use App\ActionData\Organization\OrganizationUpdateActionData;
use App\ActionResults\CommonActionResult;
use App\ActionResults\VoidActionResult;
use App\DataObjects\DataObjectPagination;
use App\DataObjects\Organization\AgentDataObject;
use App\DataObjects\Organization\OrganizationDataObject;
use App\Exceptions\BillingException;
use App\Microservice\DataObjects\Billing\OrganizationObject;
use App\Microservice\Services\BillingService;
use App\Models\AgentContract;
use App\Models\AgentData;
use App\Models\AgentProduct;
use App\Models\Organization;
use App\Models\OrganizationContract;
use App\Models\Product;
use App\Models\Profile;
use App\Models\User;
use App\Models\Warehouse;
use App\Services\Concerns\Paginator;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Organization Structure CRUD service.
 * Can create, read, update, delete: companies, filials, centres, departments, agents, company workers and sub agents.
 * When user creates, updates or deletes Organization, service returns ActionResult
 * When user reads Organization, service returns DataObject
 */
class OrganizationService
{
    use Paginator;

    private BillingService $service;

    public function __construct()
    {
        $this->service = app(BillingService::class);
    }

    /**
     * Service function for creating Companies.
     *
     * @param OrganizationActionData $action_data
     * @return CommonActionResult
     * @throws \App\Exceptions\BillingException
     * @throws ErrorException
     * @throws ValidationException
     * @throws \Throwable
     */
    public function createCompany(OrganizationActionData $action_data): CommonActionResult {
        try {
            $action_data->validate();
            DB::beginTransaction();
            DB::table('organizations')->sharedLock()->get();
            $organization = Organization::query()->create([
                'name' => $action_data->name,
                'region_id' => $action_data->region_id,
                'organization_type_id' => Organization::COMPANY,
                'company_number' => Organization::query()->max('company_number') + 1,
                'filial_number' => 0,
                'branch_number' => 0,
                'agent_number' => 0,
                'sub_agent_number' => 0,
                'inn' => $action_data->inn,
                'account' => $action_data->account,
                'address' => $action_data->address,
                'director_fio' => $action_data->director_fio,
                'director_phone' => $action_data->director_phone,
            ]);
            Warehouse::query()->create([
                'organization_id' => $organization->id
            ]);
            $user = User::query()->create([
                'login' => $action_data->login,
                'password' => Hash::make($action_data->password),
            ]);
            $user->attachRole('company_user');
            Profile::create([
                'name' => $action_data->director_fio,
                'region_id' => $action_data->region_id,
                'address' => $action_data->address,
                'phone' => $action_data->director_tel,
                'user_id' => $user->id,
                'organization_id' => $organization->id,
            ]);
            OrganizationContract::query()->create([
                'organization_id' => $organization->id,
                'user_id' => $user->id,
                'file_id' => $action_data->file_id,
            ]);
            $wallet = $this->createWallet($organization);
            if (gettype($wallet) == 'array'){
                throw new BillingException('Could not create or update a wallet');
            }
            DB::commit();
            return new CommonActionResult($organization->id);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Service function for creating Filials.
     *
     * @param FilialActionData $action_data
     * @return CommonActionResult
     * @throws \App\Exceptions\BillingException
     * @throws ErrorException
     * @throws ValidationException
     * @throws \Throwable
     */
    public function createFilial(FilialActionData $action_data): CommonActionResult {
        DB::beginTransaction();
        try {
            $action_data->validate();
            DB::table('organizations')->sharedLock()->get();
            $organization = Organization::query()->create([
                'name' => $action_data->name,
                'region_id' => $action_data->region_id,
                'parent_id' => 1,
                'organization_type_id' => Organization::FILIAL,
                'company_number' => 1,
                'filial_number' => Organization::query()->max('filial_number') + 1,
                'branch_number' => 0,
                'agent_number' => 0,
                'sub_agent_number' => 0,
                'inn' => $action_data->inn,
                'account' => $action_data->account,
                'address' => $action_data->address,
                'director_fio' => $action_data->director_fio,
                'director_phone' => $action_data->director_phone,
            ]);
            Warehouse::query()->create([
                'organization_id' => $organization->id
            ]);
            $user = User::query()->create([
                'login' => $action_data->login,
                'password' => Hash::make($action_data->password),
            ]);
            $user->attachRole('filial_user');
            Profile::create([
                'name' => $action_data->director_fio,
                'region_id' => $action_data->region_id,
                'address' => $action_data->address,
                'phone' => $action_data->director_phone,
                'user_id' => $user->id,
                'organization_id' => $organization->id,
            ]);
            OrganizationContract::query()->create([
                'organization_id' => $organization->id,
                'user_id' => $user->id,
                'file_id' => $action_data->file_id,
            ]);
            $wallet = $this->createWallet($organization);
            if (gettype($wallet) == 'array'){
                throw new BillingException('Could not create or update a wallet');
            }
            DB::commit();
            return new CommonActionResult($organization->id);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Service function for creating Centres.
     *
     * @param OrganizationActionData $action_data
     * @return CommonActionResult
     * @throws \App\Exceptions\BillingException
     * @throws ErrorException
     * @throws ValidationException
     * @throws \Throwable
     */
    public function createCentre(OrganizationActionData $action_data): CommonActionResult {
        try {
            $action_data->validate();
            DB::beginTransaction();
            DB::table('organizations')->sharedLock()->get();

            $parent = Organization::query()->findOrFail($action_data->parent_id);
            $branch_number = Organization::query()
                    ->where('filial_number', $parent->filial_number)
                    ->where('branch_number', '>', 4999)->max('branch_number') + 1;
            if ($branch_number == 1) {
                $branch_number = 5000;
            }
            $organization = Organization::query()->create([
                'name' => $action_data->name,
                'region_id' => $action_data->region_id,
                'parent_id' => $action_data->parent_id,
                'organization_type_id' => Organization::CENTRE,
                'company_number' => 1,
                'filial_number' => $parent->filial_number,
                'branch_number' => $branch_number,
                'agent_number' => 0,
                'sub_agent_number' => 0,
                'inn' => $action_data->inn,
                'account' => $action_data->account,
                'address' => $action_data->address,
                'director_fio' => $action_data->director_fio,
                'director_phone' => $action_data->director_phone,
            ]);
            Warehouse::query()->create([
                'organization_id' => $organization->id
            ]);
            $user = User::query()->create([
                'login' => $action_data->login,
                'password' => Hash::make($action_data->password),
            ]);
            $user->attachRole('centre_user');

            Profile::create([
                'name' => $action_data->director_fio,
                'region_id' => $action_data->region_id,
                'address' => $action_data->address,
                'phone' => $action_data->director_phone,
                'user_id' => $user->id,
                'organization_id' => $organization->id,
            ]);
            OrganizationContract::query()->create([
                'organization_id' => $organization->id,
                'user_id' => $user->id,
                'file_id' => $action_data->file_id,
            ]);
            $wallet = $this->createWallet($organization);
            if (gettype($wallet) == 'array'){
                throw new BillingException(json_encode($wallet));
            }
            DB::commit();
            return new CommonActionResult($organization->id);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Service function for creating Departments.
     *
     * @param OrganizationActionData $action_data
     * @return CommonActionResult
     * @throws \App\Exceptions\BillingException
     * @throws ErrorException
     * @throws ValidationException
     * @throws \Throwable
     */
    public function createDepartment(OrganizationActionData $action_data): CommonActionResult {
        try {
            $action_data->validate();
            DB::beginTransaction();
            DB::table('organizations')->sharedLock()->get();
            $parent = Organization::query()->findOrFail($action_data->parent_id);
            $organization = Organization::query()->create([
                'name' => $action_data->name,
                'region_id' => $action_data->region_id,
                'parent_id' => $action_data->parent_id,
                'organization_type_id' => Organization::DEPARTMENT,
                'company_number' => 1,
                'filial_number' => $parent->filial_number,
                'branch_number' => Organization::query()
                        ->where('filial_number', $parent->filial_number)
                        ->where('branch_number', '<', 5000)->max('branch_number') + 1,
                'agent_number' => 0,
                'sub_agent_number' => 0,
                'inn' => $action_data->inn,
                'account' => $action_data->account,
                'address' => $action_data->address,
                'director_fio' => $action_data->director_fio,
                'director_phone' => $action_data->director_phone,
            ]);
            Warehouse::query()->create([
                'organization_id' => $organization->id
            ]);
            $user = User::query()->create([
                'login' => $action_data->login,
                'password' => Hash::make($action_data->password),
            ]);
            $user->attachRole('department_user');

            Profile::create([
                'name' => $action_data->director_fio,
                'region_id' => $action_data->region_id,
                'address' => $action_data->address,
                'phone' => $action_data->director_phone,
                'user_id' => $user->id,
                'organization_id' => $organization->id,
            ]);
            OrganizationContract::query()->create([
                'organization_id' => $organization->id,
                'user_id' => $user->id,
                'file_id' => $action_data->file_id,
            ]);
            $wallet = $this->createWallet($organization);
            if (gettype($wallet) == 'array'){
                throw new BillingException('Could not create or update a wallet');
            }
            DB::commit();
            return new CommonActionResult($organization->id);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Service function for creating Agents.
     *
     * @param AgentActionData $action_data
     * @return CommonActionResult
     * @throws \App\Exceptions\BillingException
     * @throws ErrorException
     * @throws ValidationException
     * @throws \Throwable
     */
    public function createAgent(AgentActionData $action_data)
    {
        DB::beginTransaction();
        try {
            $action_data->validate();
            DB::table('organizations')->sharedLock()->get();
            $parent = Organization::query()->findOrFail($action_data->parent_id);
            if ($action_data->agent_type_id == Organization::AGENT_TYPE_FIZ){
                $agent_type_number = 1000;
            } elseif ($action_data->agent_type_id == Organization::AGENT_TYPE_YUR) {
                $agent_type_number = 2000;
            } elseif ($action_data->agent_type_id == Organization::AGENT_TYPE_COMPANY) {
                $agent_type_number = 3000;
            } elseif ($action_data->agent_type_id == Organization::AGENT_TYPE_SUB) {
                $agent_type_number = 0;
            } else {
                throw new Exception('Incorrect Agent type.');
            }
            if ($action_data->agent_type_id == Organization::AGENT_TYPE_SUB) {
                $organization = Organization::query()->create([
                    'name' => $action_data->name,
                    'organization_type_id' => Organization::AGENT,
                    'region_id' => $action_data->region_id,
                    'parent_id' => $action_data->parent_id,
                    'company_number' => 1,
                    'filial_number' => $parent->filial_number,
                    'branch_number' => $parent->branch_number,
                    'agent_number' => $parent->agent_number,
                    'sub_agent_number' => Organization::query()
                            ->where('filial_number', $parent->filial_number)
                            ->where('branch_number', $parent->branch_number)
                            ->where('agent_number', $parent->agent_number)
                            ->max('sub_agent_number') + 1,
                    'inn' => $action_data->inn,
                    'account' => $action_data->account,
                    'address' => $action_data->address,
                    'director_fio' => $action_data->director_fio,
                    'director_phone' => $action_data->director_phone,
                ]);
            } else {
                $organization = Organization::query()->create([
                    'name' => $action_data->name,
                    'organization_type_id' => Organization::AGENT,
                    'region_id' => $action_data->region_id,
                    'parent_id' => $action_data->parent_id,
                    'company_number' => 1,
                    'filial_number' => $parent->filial_number,
                    'branch_number' => $parent->branch_number,
                    'agent_number' => Organization::query()
                            ->where('filial_number', $parent->filial_number)
                            ->where('branch_number', $parent->branch_number)
                            ->max('agent_number') + 1 + $agent_type_number,
                    'sub_agent_number' => 0,
                    'inn' => $action_data->inn,
                    'account' => $action_data->account,
                    'address' => $action_data->address,
                    'director_fio' => $action_data->director_fio,
                    'director_phone' => $action_data->director_phone,
                ]);
            }
            foreach ($action_data->product_ids as $product_id){
                Product::query()->findOrFail($product_id);
                AgentProduct::query()->create([
                    'agent_id' => $organization->id,
                    'product_id' => $product_id
                ]);
            }
            Warehouse::query()->create([
                'organization_id' => $organization->id
            ]);
            AgentData::query()->create([
                'agent_type_id' => $action_data->agent_type_id,
                'organization_id' => $organization->id,
                'pinfl' => $action_data->pinfl
            ]);
            $user = User::query()->create([
                'login' => $action_data->login,
                'password' => Hash::make($action_data->password),
            ]);
            if ($action_data->agent_type_id == Organization::AGENT_TYPE_FIZ){
                $user->attachRole('agent_fiz_user');
                AgentContract::query()->create([
                    'organization_id' => $organization->id,
                    'user_id' => $user->id,
                    'date_from' => $action_data->date_from,
                    'date_to' => $action_data->date_to,
                    'number' => $action_data->number,
                    'commission' => $action_data->commission,
                    'signer' => $action_data->signer,
                    'file_id' => $action_data->file_id,
                ]);
            } elseif ($action_data->agent_type_id == Organization::AGENT_TYPE_YUR) {
                $user->attachRole('agent_yur_user');
                AgentContract::query()->create([
                    'organization_id' => $organization->id,
                    'user_id' => $user->id,
                    'date_from' => $action_data->date_from,
                    'date_to' => $action_data->date_to,
                    'number' => $action_data->number,
                    'commission' => $action_data->commission,
                    'signer' => $action_data->signer,
                    'file_id' => $action_data->file_id,
                ]);
            } elseif ($action_data->agent_type_id == Organization::AGENT_TYPE_COMPANY) {
                $user->attachRole('company_agent_user');
            } elseif ($action_data->agent_type_id == Organization::AGENT_TYPE_SUB) {
                $user->attachRole('sub_agent_user');
            }
            Profile::create([
                'name' => $action_data->director_fio,
                'region_id' => $action_data->region_id,
                'address' => $action_data->address,
                'phone' => $action_data->director_phone,
                'user_id' => $user->id,
                'organization_id' => $organization->id,
            ]);
            $wallet = $this->createWallet($organization);
            if (gettype($wallet) == 'array'){
                throw new BillingException('Could not create or update a wallet');
            }
            DB::commit();
            return new CommonActionResult($organization->id);
        } catch (Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Service function for editing some of Organization's information.
     *
     * @param OrganizationUpdateActionData $action_data
     * @return CommonActionResult
     * @throws \App\Exceptions\BillingException
     * @throws ErrorException
     * @throws ValidationException
     * @throws \Throwable
     */
    public function update(OrganizationUpdateActionData $action_data): CommonActionResult {
        try {
            $action_data->validate();
            DB::beginTransaction();
            $item = Organization::query()->findOrFail($action_data->id);
            $item->update([
                'name' => $action_data->name,
                'region_id' => $action_data->region_id,
                'inn' => $action_data->inn,
                'account' => $action_data->account,
                'address' => $action_data->address,
                'director_fio' => $action_data->director_fio,
                'director_phone' => $action_data->director_phone,
            ]);
            $wallet = $this->createWallet($item);
            if (gettype($wallet) == 'array'){
                throw new BillingException('Could not create or update a wallet');
            }
            DB::commit();
            return new CommonActionResult($item->id);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Service function for editing some of Organization's information.
     *
     * @param AgentUpdateActionData $action_data
     * @return CommonActionResult
     * @throws \App\Exceptions\BillingException
     * @throws ErrorException
     * @throws ValidationException
     * @throws \Throwable
     */
    public function updateAgent(AgentUpdateActionData $action_data): CommonActionResult {
        try {
            $action_data->validate();
            DB::beginTransaction();
            $item = Organization::query()->findOrFail($action_data->id);
            $item->update([
                'name' => $action_data->name,
                'region_id' => $action_data->region_id,
                'inn' => $action_data->inn,
                'account' => $action_data->account,
                'address' => $action_data->address,
                'director_fio' => $action_data->director_fio,
                'director_phone' => $action_data->director_phone,
            ]);
            $agent_products = AgentProduct::query()->where('agent_id', $item->id)->get();
            foreach ($agent_products as $product){
                $product->delete();
            }
            foreach ($action_data->product_ids as $product_id){
                Product::query()->findOrFail($product_id);
                AgentProduct::query()->create([
                    'agent_id' => $item->id,
                    'product_id' => $product_id
                ]);
            }
            if (!$this->createWallet($item)){
                throw new BillingException('Could not create or update a wallet');
            }
            DB::commit();
            return new CommonActionResult($item->id);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Service function for getting information of Company, Filial, Centre or Department.
     *
     * @param int $id
     * @return OrganizationDataObject
     */
    public function get(int $id){
        $item = Organization::query()->where('is_deleted', '=', false)->findOrFail($id);
        $result = new OrganizationDataObject($item->toArray());
        $result->region = $item->region;
        $result->parent = $item->parent;
        $result->deposit_number =
            str_pad($item->company_number, 4, '0', STR_PAD_LEFT). ' '.
            str_pad($item->filial_number, 4, '0', STR_PAD_LEFT). ' '.
            str_pad($item->branch_number, 4, '0', STR_PAD_LEFT). ' '.
            str_pad($item->agent_number, 4, '0', STR_PAD_LEFT). ' '.
            str_pad($item->sub_agent_number, 4, '0', STR_PAD_LEFT);
        return $result;
    }

    /**
     * Service function for getting information of Web.
     *
     * @param int $id
     * @return AgentDataObject
     */
    public function getAgent(int $id){
        $item = Organization::query()
            ->where('organization_type_id', Organization::AGENT)
            ->where('is_deleted', '=', false)
            ->findOrFail($id);
        $result = new AgentDataObject($item->toArray());
        $result->region = $item->region;
        $result->products = $item->agentProducts;
        $result->parent = $item->parent;
        $agentData = $item->agentData;
        $contract = $item->agentContract;
        if ($agentData){
            $result->agent_type_id = $agentData->agent_type_id;
            $result->agent_type = $agentData->agentType;
            $result->pinfl = $agentData->pinfl;
        }
        if ($contract){
            $result->commission = $contract->commission;
        }
        $result->deposit_number =
            str_pad($item->company_number, 4, '0', STR_PAD_LEFT). ' '.
            str_pad($item->filial_number, 4, '0', STR_PAD_LEFT). ' '.
            str_pad($item->branch_number, 4, '0', STR_PAD_LEFT). ' '.
            str_pad($item->agent_number, 4, '0', STR_PAD_LEFT). ' '.
            str_pad($item->sub_agent_number, 4, '0', STR_PAD_LEFT);
        return $result;
    }

    /**
     * Service function for deleting Organization.
     *
     * @param int $id
     * @return VoidActionResult
     */
    public function delete(int $id){
        $item = Organization::query()->findOrFail($id);
        $item->update([
            'status' => Organization::STATUS_PASSIVE,
            'is_deleted' => true
        ]);
        return new VoidActionResult();
    }

    /**
     * Service function for getting Companies, Filials, Centres and Departments as DataObjectPagination.
     *
     * @param string $type
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginate(string $type, int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
        $closure = function ($item) {
            $result = new OrganizationDataObject($item->toArray());
            $result->region = $item->region;
            $result->parent = $item->parent;
            $result->deposit_number =
                str_pad($item->company_number, 4, '0', STR_PAD_LEFT). ' '.
                str_pad($item->filial_number, 4, '0', STR_PAD_LEFT). ' '.
                str_pad($item->branch_number, 4, '0', STR_PAD_LEFT). ' '.
                str_pad($item->agent_number, 4, '0', STR_PAD_LEFT). ' '.
                str_pad($item->sub_agent_number, 4, '0', STR_PAD_LEFT);
            return $result;
        };

        return $this->filterAndPaginate(
            Organization::query()
                ->where('organization_type_id', $type)
                ->where('is_deleted', '=', false),
            $page,
            $limit,
            $closure,
            $filters
        );
    }

    /**
     * Service function for getting Companies, Filials, Centres and Departments as DataObjectPagination.
     *
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginateOrganization(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
        $closure = function ($item) {
            $result = new OrganizationDataObject($item->toArray());
            $result->region = $item->region;
            $result->parent = $item->parent;
            $result->deposit_number =
                str_pad($item->company_number, 4, '0', STR_PAD_LEFT). ' '.
                str_pad($item->filial_number, 4, '0', STR_PAD_LEFT). ' '.
                str_pad($item->branch_number, 4, '0', STR_PAD_LEFT). ' '.
                str_pad($item->agent_number, 4, '0', STR_PAD_LEFT). ' '.
                str_pad($item->sub_agent_number, 4, '0', STR_PAD_LEFT);
            return $result;
        };

        return $this->filterAndPaginate(
            Organization::query()
                ->where('is_deleted', '=', false),
            $page,
            $limit,
            $closure,
            $filters
        );
    }

    /**
     * Service function for getting Agents as DataObjectPagination.
     *
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginateAgent(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
        $closure = function ($item) {
            $result = new AgentDataObject($item->toArray());
            $result->region = $item->region;
            $result->parent = $item->parent;
            $agentData = $item->agentData;
            $contract = $item->agentContract;
            if ($agentData){
                $result->agent_type_id = $agentData->agent_type_id;
                $result->agent_type = $agentData->agentType;
                $result->pinfl = $agentData->pinfl;
            }
            if ($contract){
                $result->commission = $contract->commission;
            }
            $result->deposit_number =
                str_pad($item->company_number, 4, '0', STR_PAD_LEFT). ' '.
                str_pad($item->filial_number, 4, '0', STR_PAD_LEFT). ' '.
                str_pad($item->branch_number, 4, '0', STR_PAD_LEFT). ' '.
                str_pad($item->agent_number, 4, '0', STR_PAD_LEFT). ' '.
                str_pad($item->sub_agent_number, 4, '0', STR_PAD_LEFT);
            return $result;
        };

        return $this->filterAndPaginate(
            Organization::query()
                ->where('organization_type_id', Organization::AGENT)
                ->where('is_deleted', '=', false),
            $page,
            $limit,
            $closure,
            $filters
        );
    }

    /**
     * @param Organization $organization
     * @return bool
     * @throws ErrorException
     * @throws ValidationException
     */
    private function createWallet(Organization $organization){
        $billing_result = $this->service->updateOrCreateOrganization(new OrganizationObject([
            'organization_id' => $organization->id,
            'currency' => 'UZS'
        ]));

        if (data_get($billing_result, 'success')){
            return data_get($billing_result, 'success');
        }else {
            return data_get($billing_result, 'message');
        }
    }
}
