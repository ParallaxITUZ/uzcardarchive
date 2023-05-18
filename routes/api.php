<?php

use App\Http\Controllers\Api\DatabaseRefreshAction;
use App\Http\Controllers\Api\FileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('refresh-seed', DatabaseRefreshAction::class);

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/service/file-upload', [FileController::class, 'store']);
        Route::rpcEndpoint('service', function () {
            Route::rpc('logout', 'AuthProcedure@logout');
            Route::rpc('refresh', 'AuthProcedure@refresh');
            Route::rpc('me', 'AuthProcedure@me');
            Route::rpc('file.get', 'FileProcedure@get');

            Route::rpc('dictionaries.index', 'DictionaryProcedure@index');
            Route::rpc('dictionaries.store', 'DictionaryProcedure@store');
            Route::rpc('dictionaries.update', 'DictionaryProcedure@update');
            Route::rpc('dictionaries.show', 'DictionaryProcedure@show');
            Route::rpc('dictionaries.get', 'DictionaryProcedure@get');
            Route::rpc('dictionaries.conf', 'DictionaryProcedure@conf');
            Route::rpc('dictionaries.delete', 'DictionaryProcedure@destroy');

            Route::rpc('dictionary-items.index', 'DictionaryItemProcedure@index');
            Route::rpc('dictionary-items.store', 'DictionaryItemProcedure@store');
            Route::rpc('dictionary-items.update', 'DictionaryItemProcedure@update');
            Route::rpc('dictionary-items.show', 'DictionaryItemProcedure@show');
            Route::rpc('dictionary-items.delete', 'DictionaryItemProcedure@destroy');

            Route::rpc('roles.index', 'RoleProcedure@index');
            Route::rpc('roles.store', 'RoleProcedure@store');
            Route::rpc('roles.update', 'RoleProcedure@update');
            Route::rpc('roles.show', 'RoleProcedure@show');
            Route::rpc('roles.get', 'RoleProcedure@get');
            Route::rpc('roles.delete', 'RoleProcedure@destroy');

            Route::rpc('permissions.index', 'PermissionProcedure@index');
            Route::rpc('permissions.store', 'PermissionProcedure@store');
            Route::rpc('permissions.update', 'PermissionProcedure@update');
            Route::rpc('permissions.show', 'PermissionProcedure@show');
            Route::rpc('permissions.get', 'PermissionProcedure@get');
            Route::rpc('permissions.delete', 'PermissionProcedure@destroy');

            Route::rpc('organizations.index', 'CompanyProcedure@organizations');
            Route::rpc('companies.index', 'CompanyProcedure@index');
            Route::rpc('companies.store', 'CompanyProcedure@store');
            Route::rpc('companies.update', 'CompanyProcedure@update');
            Route::rpc('companies.show', 'CompanyProcedure@show');
            Route::rpc('companies.delete', 'CompanyProcedure@destroy');

            Route::rpc('filials.index', 'FilialProcedure@index');
            Route::rpc('filials.store', 'FilialProcedure@store');
            Route::rpc('filials.update', 'FilialProcedure@update');
            Route::rpc('filials.show', 'FilialProcedure@show');
            Route::rpc('filials.delete', 'FilialProcedure@destroy');

            Route::rpc('centres.index', 'CentreProcedure@index');
            Route::rpc('centres.store', 'CentreProcedure@store');
            Route::rpc('centres.update', 'CentreProcedure@update');
            Route::rpc('centres.show', 'CentreProcedure@show');
            Route::rpc('centres.delete', 'CentreProcedure@destroy');

            Route::rpc('departments.index', 'DepartmentProcedure@index');
            Route::rpc('departments.store', 'DepartmentProcedure@store');
            Route::rpc('departments.update', 'DepartmentProcedure@update');
            Route::rpc('departments.show', 'DepartmentProcedure@show');
            Route::rpc('departments.delete', 'DepartmentProcedure@destroy');

            Route::rpc('agents.index', 'AgentProcedure@index');
            Route::rpc('agents.store', 'AgentProcedure@store');
            Route::rpc('agents.update', 'AgentProcedure@update');
            Route::rpc('agents.show', 'AgentProcedure@show');
            Route::rpc('agents.delete', 'AgentProcedure@destroy');

            Route::rpc('workers.index', 'UserProcedure@index');
            Route::rpc('workers.store', 'UserProcedure@store');
            Route::rpc('workers.update', 'UserProcedure@update');
            Route::rpc('workers.show', 'UserProcedure@show');
            Route::rpc('workers.deactivate', 'UserProcedure@deactivate');
            Route::rpc('workers.activate', 'UserProcedure@activate');
            Route::rpc('workers.delete', 'UserProcedure@destroy');

            Route::rpc('products.index', 'ProductProcedure@index');
            Route::rpc('products.store', 'ProductProcedure@store');
            Route::rpc('products.get', 'ProductProcedure@get');
            Route::rpc('products.update', 'ProductProcedure@update');
            Route::rpc('products.delete', 'ProductProcedure@destroy');

            Route::rpc('product-tariffs.index', 'ProductTariffProcedure@index');
            Route::rpc('product-tariffs.store', 'ProductTariffProcedure@store');
            Route::rpc('product-tariffs.get', 'ProductTariffProcedure@get');
            Route::rpc('product-tariffs.update', 'ProductTariffProcedure@update');
            Route::rpc('product-tariffs.delete', 'ProductTariffProcedure@destroy');

            Route::rpc('product-tariff-conditions.index', 'ProductTariffConditionProcedure@index');
            Route::rpc('product-tariff-conditions.store', 'ProductTariffConditionProcedure@store');
            Route::rpc('product-tariff-conditions.get', 'ProductTariffConditionProcedure@get');
            Route::rpc('product-tariff-conditions.update', 'ProductTariffConditionProcedure@update');
            Route::rpc('product-tariff-conditions.delete', 'ProductTariffConditionProcedure@destroy');

            Route::rpc('product-tariff-configurations.index', 'ProductTariffConfigurationProcedure@index');
            Route::rpc('product-tariff-configurations.store', 'ProductTariffConfigurationProcedure@store');
            Route::rpc('product-tariff-configurations.get', 'ProductTariffConfigurationProcedure@get');
            Route::rpc('product-tariff-configurations.update', 'ProductTariffConfigurationProcedure@update');
            Route::rpc('product-tariff-configurations.delete', 'ProductTariffConfigurationProcedure@destroy');

            Route::rpc('product-tariff-bonuses.index', 'ProductTariffBonusProcedure@index');
            Route::rpc('product-tariff-bonuses.store', 'ProductTariffBonusProcedure@store');
            Route::rpc('product-tariff-bonuses.get', 'ProductTariffBonusProcedure@get');
            Route::rpc('product-tariff-bonuses.update', 'ProductTariffBonusProcedure@update');
            Route::rpc('product-tariff-bonuses.delete', 'ProductTariffBonusProcedure@destroy');

            Route::rpc('product-tariff-risks.index', 'ProductTariffRiskProcedure@index');
            Route::rpc('product-tariff-risks.store', 'ProductTariffRiskProcedure@store');
            Route::rpc('product-tariff-risks.get', 'ProductTariffRiskProcedure@get');
            Route::rpc('product-tariff-risks.update', 'ProductTariffRiskProcedure@update');
            Route::rpc('product-tariff-risks.delete', 'ProductTariffRiskProcedure@destroy');

            Route::rpc('warehouses.index', 'WarehouseProcedure@index');
            Route::rpc('warehouses.items', 'WarehouseProcedure@items');
            Route::rpc('warehouses.import', 'WarehouseProcedure@import');
//            Route::rpc('warehouses.get', 'WarehouseProcedure@get');

            Route::rpc('policies.index', 'PolicyProcedure@index');
            Route::rpc('policies.store', 'PolicyProcedure@store');
            Route::rpc('policies.get', 'PolicyProcedure@get');
            Route::rpc('policies.deactivate', 'PolicyProcedure@deactivate');
            Route::rpc('policies.activate', 'PolicyProcedure@activate');
            Route::rpc('policies.update', 'PolicyProcedure@update');
            Route::rpc('policies.delete', 'PolicyProcedure@destroy');

            Route::rpc('contract-policies.index', 'ContractPolicyProcedure@index');

            Route::rpc('policy-requests.index', 'PolicyRequestProcedure@index');
            Route::rpc('policy-requests.sent', 'PolicyRequestProcedure@sent');
            Route::rpc('policy-requests.received', 'PolicyRequestProcedure@received');
            Route::rpc('policy-requests.axo', 'PolicyRequestProcedure@axo');
            Route::rpc('policy-requests.approve-all', 'PolicyRequestProcedure@approveAll');
            Route::rpc('policy-requests.approve', 'PolicyRequestProcedure@approve');
            Route::rpc('policy-requests.store', 'PolicyRequestProcedure@store');
            Route::rpc('policy-requests.reject', 'PolicyRequestProcedure@reject');
            Route::rpc('policy-requests.get', 'PolicyRequestProcedure@get');
            Route::rpc('policy-requests.update', 'PolicyRequestProcedure@update');
            Route::rpc('policy-requests.delete', 'PolicyRequestProcedure@destroy');

            Route::rpc('policy-transfers.index', 'PolicyTransferProcedure@index');
            Route::rpc('policy-transfers.store', 'PolicyTransferProcedure@store');
            Route::rpc('policy-transfers.sent', 'PolicyTransferProcedure@sent');
            Route::rpc('policy-transfers.received', 'PolicyTransferProcedure@received');

            Route::rpc('client-contracts.index', 'ClientContractProcedure@index');
            Route::rpc('client-contracts.store', 'ClientContractProcedure@store');
            Route::rpc('re-client-contracts.restore', 'ClientContractProcedure@restore');
            Route::rpc('client-contracts.get', 'ClientContractProcedure@get');
            Route::rpc('client-contracts.update', 'ClientContractProcedure@update');
            Route::rpc('client-contracts.delete', 'ClientContractProcedure@destroy');
            Route::rpc('client-contracts.cancel', 'ClientContractProcedure@cancel');

            Route::rpc('clients.getIndividual', 'ClientProcedure@getIndividual');
            Route::rpc('clients.getLegal', 'ClientProcedure@getLegal');
            Route::rpc('clients.legals', 'ClientProcedure@legals');
            Route::rpc('clients.individuals', 'ClientProcedure@individuals');

            Route::rpc('invoices.index', 'InvoiceProcedure@index');
            Route::rpc('invoices.paid', 'InvoiceProcedure@paid');
            Route::rpc('invoices.cancel', 'InvoiceProcedure@cancel');

            Route::rpc('programs.travel', 'ProgramProcedure@travel');

            Route::rpc('calculators.travel', 'CalculatorProcedure@travel');
            Route::rpc('calculators.osago', 'CalculatorProcedure@osago');

            Route::rpc('fond.get', 'FondProcedure@all');
            Route::rpc('fond.vehicle', 'FondProcedure@vehicle');
            Route::rpc('fond.person', 'FondProcedure@person');
            Route::rpc('fond.organization', 'FondProcedure@organization');
            Route::rpc('fond.pinfl', 'FondProcedure@pinfl');
            Route::rpc('fond.pensioner', 'FondProcedure@pensioner');
            Route::rpc('fond.provided-discount', 'FondProcedure@providedDiscount');

            Route::rpc('attempts.index', 'AttemptProcedure@index');
            Route::rpc('attempts.store', 'AttemptProcedure@store');
            Route::rpc('attempts.get', 'AttemptProcedure@get');
            Route::rpc('attempts.send-message', 'AttemptProcedure@sendMessage');
            Route::rpc('attempts.check-phone', 'AttemptProcedure@checkMessage');
            Route::rpc('attempts.update', 'AttemptProcedure@update');
            Route::rpc('attempts.delete', 'AttemptProcedure@destroy');


            Route::rpc('re-calculators.osago', 'ReCalculatorProcedure@osago');
            Route::rpc('re-calculators.travel', 'ReCalculatorProcedure@travel');
        });
    });

    Route::rpcEndpoint('auth', function () {
        Route::rpc('login', 'AuthProcedure@login');
        Route::rpc('login-worker', 'AuthProcedure@loginWorker');
    });
});
