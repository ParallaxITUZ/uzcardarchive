<?php

namespace Database\Seeders;

use App\Models\PolicyRequest;
use App\Models\PolicyRequestItem;
use App\Models\PolicyTransfer;
use App\Models\PolicyTransferItem;
use App\Models\WarehouseItem;
use Carbon\Traits\Date;
use Illuminate\Database\Seeder;

class PolicyRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PolicyRequest::query()->create([
            'id' => 0,
            'sender_id' => 1,
            'receiver_id' => 0,
            'requested_user_id' => 1,
            'approved_user_id' => 1,
            'delivery_date' => "2022-01-01 00:00:00",
            'comment' => 'Request for Imports',
        ]);

        PolicyRequestItem::query()->create([
            'id' => 0,
            'policy_request_id' => PolicyRequest::IMPORT,
            'policy_id' => 1,
            'amount' => 1,
            'approved_amount' => 1,
        ]);

        $transfer = PolicyTransfer::query()->create([
            'from_warehouse_id' => 1,
            'to_warehouse_id' => 2,
            'policy_request_id' => 0
        ]);
        $item = WarehouseItem::query()->create([
            'warehouse_id' => $transfer->to_warehouse_id,
            'policy_id' => 2,
            'series' => "EKFL",
            'number_from' => 1001,
            'number_to' => 5000,
            'amount' => 4000,
        ]);
        $ware = WarehouseItem::query()->findOrFail(1);
        $ware->update([
            'amount' => $ware->amount-4000,
        ]);
        PolicyTransferItem::query()->create([
            'policy_transfer_id' => $transfer->id,
            'from_warehouse_item_id' => $ware->id,
            'to_warehouse_item_id' => $item->id,
            'policy_id' => 2,
            'series' => "EKFL",
            'number_from' => 1001,
            'number_to' => 5000,
            'amount' => 4000,
            'axo_user_id' => 1,
            'request_item_id' => 0
        ]);
    }
}
