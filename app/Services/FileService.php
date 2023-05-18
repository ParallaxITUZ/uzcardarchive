<?php

namespace App\Services;

use App\ActionData\File\FileActionData;
use App\ActionResults\CommonActionResult;
use App\DataObjects\File\FileDataObject;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FileService
{
    /**
     * @param FileActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(FileActionData $action_data): CommonActionResult {
        $action_data->validate();
        $filename = $action_data->file->storeAs('files', Str::uuid().'.'.$action_data->file->extension());
        $permission = File::query()->create([
            'filename' => $action_data->file->getClientOriginalName(),
            'path' => $filename,
            'extension' => $action_data->file->extension(),
            'type' => $action_data->file->extension(),
            'size' => $action_data->file->getSize(),
            'user_id' => Auth::user()->id
        ]);
        return new CommonActionResult($permission->id);
    }

    public function get(int $id){
        return new FileDataObject(File::query()->findOrFail($id)->toArray());
    }
}
