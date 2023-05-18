<?php

namespace App\Services;

use App\ActionData\DictionaryItem\DictionaryItemActionData;
use App\ActionData\DictionaryItem\DictionaryItemUpdateActionData;
use App\ActionResults\CommonActionResult;
use App\ActionResults\VoidActionResult;
use App\DataObjects\DataObjectPagination;
use App\DataObjects\DictionaryItem\DictionaryItemDataObject;
use App\Models\DictionaryItem;

class DictionaryItemService
{
    /**
     * @param DictionaryItemActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(DictionaryItemActionData $action_data): CommonActionResult {
        $action_data->validate();
        $item = DictionaryItem::query()->create([
            'display_name' => $action_data->display_name,
            'description' => $action_data->description,
            'parent_id' => $action_data->parent_id,
            'dictionary_id' => $action_data->dictionary_id,
            'value' => $action_data->value,
            'order' => $action_data->order
        ]);
        return new CommonActionResult($item->id);
    }

    /**
     * @param DictionaryItemUpdateActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(DictionaryItemUpdateActionData $action_data){
        $action_data->validate();
        $item = DictionaryItem::query()->findOrFail($action_data->id);
        $item->update([
            'display_name' => $action_data->display_name,
            'description' => $action_data->description,
            'order' => $action_data->order
        ]);
        return new CommonActionResult($item->id);
    }

    /**
     * @param int $id
     * @return VoidActionResult
     */
    public function delete(int $id){
        $item = DictionaryItem::query()->findOrFail($id);
        $item->update([
            'is_deleted' => true
        ]);
        return new VoidActionResult();
    }

    /**
     * @param int $id
     * @return DictionaryItemDataObject
     */
    public function get(int $id){
        $item = DictionaryItem::query()->findOrFail($id);
        $result = new DictionaryItemDataObject($item->toArray());
        $result->items = $this->getItems($item);
        return $result;
    }

    /**
     * @param int $id
     * @return DictionaryItemDataObject
     */
    public function getOriginal(int $id){
        $item = DictionaryItem::query()->findOrFail($id);
        $result = new DictionaryItemDataObject($item->toArray());
        $result->display_name = json_decode($item->getRawOriginal('display_name'));
        $result->description = json_decode($item->getRawOriginal('description'));
        $result->items = $this->getItems($item);
        return $result;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginate(int $page = 1, int $limit = 25, ?iterable $filters = null){
        $models = DictionaryItem::query()->where('is_deleted', false)->latest()->paginate($limit);
        $items = $models->getCollection()->transform(function ($item){
            $result = new DictionaryItemDataObject($item->toArray());
            $result->display_name = json_decode($item->getRawOriginal('display_name'));
            $result->description = json_decode($item->getRawOriginal('description'));
            $result->items = $item->items;
            return $result;
        });
        return new DataObjectPagination($items, $models->total(), $limit, $page);
    }

    /**
     * @param $dictionary
     * @return array
     */
    public function getItems($dictionary){
        $result = [];
        foreach ($dictionary->items as $item){
            $object = new DictionaryItemDataObject($item->toArray());
            $object->display_name = json_decode($item->getRawOriginal('display_name'));
            $object->description = json_decode($item->getRawOriginal('description'));
            $result[] = $object;
        }
        return $result;
    }
}
