<?php

namespace Database\Seeders;

use App\Models\AgentData;
use App\Models\Organization;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organization::create([
            'id' => Organization::FOND,
            'name' => '{"uz": "FOND", "ru": "FOND"}',
            'region_id' => 14,
            'inn' => '1111111',
            'company_number' => 0,
            'filial_number' => 0,
            'branch_number' => 0,
            'agent_number' => 0,
            'sub_agent_number' => 0,
            'organization_type_id' => Organization::COMPANY,
            'account' => '1111111',
            'address' => '{"uz": "Fond", "ru": "Fond"}',
            'director_fio' => 'A A A',
            'director_phone' => '+998901111111',
        ]);
        $company = Organization::create([
            'name' => '{"uz": "Kafolat", "ru": "Кафолат"}',
            'region_id' => 14,
            'inn' => '111222333',
            'company_number' => 1,
            'filial_number' => 0,
            'branch_number' => 0,
            'agent_number' => 0,
            'sub_agent_number' => 0,
            'organization_type_id' => Organization::COMPANY,
            'account' => '1234567',
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'director_fio' => 'A A A',
            'director_phone' => '+998901234567',
        ]);
        $admin = User::query()->find(User::SUPER_ADMIN);
        Profile::create([
            'name' => 'Xusniddin',
            'region_id' => 14,
            'address' => '{"uz": "Toshkent sh., Uchtepa t., 3-Xayratiy 18", "ru": "г. Ташкент, Учтепа, 3-Хайратий 18"}',
            'phone' => '+998903235221',
            'user_id' => $admin->id,
            'organization_id' => $company->id,
        ]);
        $user_company = User::create([
            'login' => 'kafolat',
            'password' => Hash::make('kafolat123'),
        ]);
        $user_company->attachRole('company_user');
        Profile::create([
            'name' => 'Kafolat',
            'region_id' => 14,
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'phone' => '+998901234567',
            'user_id' => $user_company->id,
            'organization_id' => $company->id,
        ]);
        $company_axo = User::create([
            'login' => 'kafolat_axo',
            'password' => Hash::make('kafolataxo123'),
        ]);
        $company_axo->attachRole('company_axo');
        Profile::create([
            'name' => 'Kafolat Axo',
            'region_id' => 14,
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'phone' => '+998901234567',
            'user_id' => $company_axo->id,
            'organization_id' => $company->id,
        ]);
        $tashkent = Organization::create([
            'name' => '{"uz": "Toshkent", "ru": "Ташкент"}',
            'region_id' => 14,
            'parent_id' => $company->id,
            'company_number' => $company->company_number,
            'filial_number' => 1,
            'branch_number' => 0,
            'agent_number' => 0,
            'sub_agent_number' => 0,
            'inn' => '111222333',
            'organization_type_id' => Organization::FILIAL,
            'account' => '1234567',
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'director_fio' => 'A A A',
            'director_phone' => '+998901234567',
        ]);
        $user_tashkent = User::create([
            'login' => 'toshkent',
            'password' => Hash::make('toshkent123'),
        ]);
        $user_tashkent->attachRole('filial_user');
        Profile::create([
            'name' => 'Toshkent',
            'region_id' => 14,
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'phone' => '+998901234567',
            'user_id' => $user_tashkent->id,
            'organization_id' => $tashkent->id,
        ]);
        $tashkent_axo = User::create([
            'login' => 'toshkent_axo',
            'password' => Hash::make('toshkent123'),
        ]);
        $tashkent_axo->attachRole('filial_axo');
        Profile::create([
            'name' => 'Toshkent',
            'region_id' => 14,
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'phone' => '+998901234567',
            'user_id' => $tashkent_axo->id,
            'organization_id' => $tashkent->id,
        ]);

        $samarqand = Organization::create([
            'name' => '{"uz": "Samarqand", "ru": "Самарканд"}',
            'region_id' => 14,
            'parent_id' => $company->id,
            'company_number' => $company->company_number,
            'filial_number' => 2,
            'branch_number' => 0,
            'agent_number' => 0,
            'sub_agent_number' => 0,
            'inn' => '111222333',
            'organization_type_id' => Organization::FILIAL,
            'account' => '1234567',
            'address' => '{"uz": "6 Amir Temur Avenue, Samarqand 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Самарканд 100000, Узбекистан"}',
            'director_fio' => 'A A A',
            'director_phone' => '+998901234567',
        ]);
        $user_samarqand = User::create([
            'login' => 'samarqand',
            'password' => Hash::make('kafolat123'),
        ]);
        $user_samarqand->attachRole('filial_user');
        Profile::create([
            'name' => 'Samarqand',
            'region_id' => 14,
            'address' => '{"uz": "6 Amir Temur Avenue, Samarqand 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Самарканд 100000, Узбекистан"}',
            'phone' => '+998901234567',
            'user_id' => $user_samarqand->id,
            'organization_id' => $samarqand->id,
        ]);
        $samarqand_axo = User::create([
            'login' => 'samarqand_axo',
            'password' => Hash::make('kafolat123'),
        ]);
        $samarqand_axo->attachRole('filial_axo');
        Profile::create([
            'name' => 'Samarqand',
            'region_id' => 14,
            'address' => '{"uz": "6 Amir Temur Avenue, Samarqand 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Самарканд 100000, Узбекистан"}',
            'phone' => '+998901234567',
            'user_id' => $samarqand_axo->id,
            'organization_id' => $samarqand->id,
        ]);

        $centre = Organization::create([
            'name' => '{"uz": "Markaz", "ru": "Центр"}',
            'region_id' => 14,
            'parent_id' => $tashkent->id,
            'company_number' => $company->company_number,
            'filial_number' => $tashkent->filial_number,
            'branch_number' => 5000,
            'agent_number' => 0,
            'sub_agent_number' => 0,
            'inn' => '111222333',
            'organization_type_id' => Organization::CENTRE,
            'account' => '1234567',
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'director_fio' => 'A A A',
            'director_phone' => '+998901234567',
        ]);
        $user_centre = User::create([
            'login' => 'markaz',
            'password' => Hash::make('markaz123'),
        ]);
        $user_centre->attachRole('branch_user');
        Profile::create([
            'name' => 'Markaz',
            'region_id' => 14,
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'phone' => '+998901234567',
            'user_id' => $user_centre->id,
            'organization_id' => $centre->id,
        ]);
        $centre_axo = User::create([
            'login' => 'markaz_axo',
            'password' => Hash::make('markaz123'),
        ]);
        $centre_axo->attachRole('branch_axo');
        Profile::create([
            'name' => 'Markaz',
            'region_id' => 14,
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'phone' => '+998901234567',
            'user_id' => $centre_axo->id,
            'organization_id' => $centre->id,
        ]);

        $department = Organization::create([
            'name' => '{"uz": "Bo\'lim", "ru": "Отделение"}',
            'region_id' => 14,
            'parent_id' => $tashkent->id,
            'company_number' => $company->company_number,
            'filial_number' => $tashkent->filial_number,
            'branch_number' => 1,
            'agent_number' => 0,
            'sub_agent_number' => 0,
            'inn' => '111222333',
            'organization_type_id' => Organization::DEPARTMENT,
            'account' => '1234567',
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'director_fio' => 'A A A',
            'director_phone' => '+998901234567',
        ]);
        $user_department = User::create([
            'login' => 'department',
            'password' => Hash::make('department123'),
        ]);
        $user_department->attachRole('branch_user');
        Profile::create([
            'name' => 'Bo\'lim',
            'region_id' => 14,
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'phone' => '+998901234567',
            'user_id' => $user_department->id,
            'organization_id' => $department->id,
        ]);
        $department_axo = User::create([
            'login' => 'department_axo',
            'password' => Hash::make('department123'),
        ]);
        $department_axo->attachRole('branch_axo');
        Profile::create([
            'name' => 'Bo\'lim',
            'region_id' => 14,
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'phone' => '+998901234567',
            'user_id' => $department_axo->id,
            'organization_id' => $department->id,
        ]);
        $agent_centre = Organization::create([
            'name' => '{"uz": "Markaz Web", "ru": "Web Центр"}',
            'region_id' => 14,
            'parent_id' => $centre->id,
            'company_number' => $company->company_number,
            'filial_number' => $tashkent->filial_number,
            'branch_number' => $centre->branch_number,
            'agent_number' => 1,
            'sub_agent_number' => 1,
            'inn' => '111222333',
            'organization_type_id' => Organization::AGENT,
            'account' => '1234567',
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'director_fio' => 'A A A',
            'director_phone' => '+998901234567',
        ]);
        $user_centre_agent = User::create([
            'login' => 'centre_agent',
            'password' => Hash::make('centreagent123'),
        ]);
        $user_centre_agent->attachRole('agent_yur_user');
        Profile::create([
            'name' => 'Markaz Web',
            'region_id' => 14,
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'phone' => '+998901234567',
            'user_id' => $user_centre_agent->id,
            'organization_id' => $agent_centre->id,
        ]);
        AgentData::query()->create([
            'agent_type_id' => Organization::AGENT_TYPE_FIZ,
            'organization_id' => $agent_centre->id,
            'pinfl' => 12312312312312
        ]);

        $agent_department = Organization::create([
            'name' => '{"uz": "Bo\'lim Web", "ru": "Web Отделение"}',
            'region_id' => 14,
            'parent_id' => $department->id,
            'company_number' => $company->company_number,
            'filial_number' => $tashkent->filial_number,
            'branch_number' => $department->branch_number,
            'agent_number' => 1,
            'sub_agent_number' => 1,
            'inn' => '111222333',
            'organization_type_id' => Organization::AGENT,
            'account' => '1234567',
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'director_fio' => 'A A A',
            'director_phone' => '+998901234567',
        ]);
        $user_department_agent = User::create([
            'login' => 'department_agent',
            'password' => Hash::make('departmentagent123'),
        ]);
        $user_department_agent->attachRole('agent_fiz_user');
        Profile::create([
            'name' => 'Bo\'lim Web',
            'region_id' => 14,
            'address' => '{"uz": "6 Amir Temur Avenue, Tashkent 100000, Uzbekistan", "ru": "Проспект Амира Темура 6, Ташкент 100000, Узбекистан"}',
            'phone' => '+998901234567',
            'user_id' => $user_department_agent->id,
            'organization_id' => $agent_department->id,
        ]);
        AgentData::query()->create([
            'agent_type_id' => Organization::AGENT_TYPE_YUR,
            'organization_id' => $agent_department->id,
            'pinfl' => 12312312312312
        ]);
    }
}
