<?php

namespace App\Services;

use App\ActionData\Pdf\TravelActionData;

class PdfService
{
    public function travel(TravelActionData $action_data)
    {
        $action_data->validate();
    }

}
