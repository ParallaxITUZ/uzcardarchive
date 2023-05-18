<?php

namespace App\Services;

use App\ActionData\Dictionary\DictionaryActionData;
use App\ActionResults\CommonActionResult;
use App\Contracts\PaginatorInterface;
use App\DataObjects\DataObjectPagination;
use App\DataObjects\Dictionary\DictionaryDataObject;
use App\DataObjects\DictionaryItem\DictionaryConfDataObject;
use App\DataObjects\DictionaryItem\DictionaryItemDataObject;
use App\Models\Dictionary;
use App\Services\Concerns\Paginator;

class DictionaryService implements PaginatorInterface
{
    use Paginator;

    /**
     * @param DictionaryActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(DictionaryActionData $action_data): CommonActionResult {
        $action_data->validate();
        $item = Dictionary::query()->create([
            'name' => $action_data->name,
            'display_name' => $action_data->display_name
        ]);
        return new CommonActionResult($item->id);
    }

    /**
     * @param DictionaryActionData $action_data
     * @return CommonActionResult
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(DictionaryActionData $action_data): CommonActionResult {
        $action_data->validate();
        $item = Dictionary::query()->findOrFail($action_data->id);
        $item->update([
            'name' => $action_data->name,
            'display_name' => $action_data->display_name
        ]);
        return new CommonActionResult($item->id);
    }

    /**
     * @param int $id
     * @return \App\ActionResults\CommonActionResult
     */
    public function delete(int $id){
        $item = Dictionary::query()->findOrFail($id);
        $item->update([
            'is_deleted' => true
        ]);
        return new CommonActionResult($id);
    }

    /**
     * @param int $id
     * @return DictionaryDataObject
     */
    public function showById(int $id){
        $item = Dictionary::query()->findOrFail($id);
        $result = new DictionaryDataObject($item->toArray());
        $result->items = $this->showItems($item);
        return $result;
    }

    /**
     * @param string $name
     * @return DictionaryDataObject
     */
    public function showByName(string $name){
        $item = Dictionary::query()->where('name', $name)->firstOrFail();
        $result = new DictionaryDataObject($item->toArray());
        $result->items = $this->showItems($item);
        return $result;
    }

    /**
     * @param int $id
     * @return DictionaryDataObject
     */
    public function getById(int $id){
        $item = Dictionary::query()->findOrFail($id);
        return new DictionaryDataObject($item->toArray());
    }

    /**
     * @param string $name
     * @return DictionaryDataObject
     */
    public function getByName(string $name){
        $item = Dictionary::query()->where('name', $name)->firstOrFail();
        $result = new DictionaryDataObject($item->toArray());
        $result->display_name = json_decode($item->getRawOriginal('display_name'));
        $result->items = $this->showItems($item);
        return $result;
    }

    /**
     * @param string $name
     * @return \App\DataObjects\DictionaryItem\DictionaryConfDataObject
     */
    public function conf(string $name){
        $item = Dictionary::query()->where('name', $name)->firstOrFail();
        $result = new DictionaryConfDataObject($item->toArray());
        $result->items = $this->showItemsConfs($item);
        return $result;
    }

    /**
     * @param int $page
     * @param int $limit
     * @param iterable|null $filters
     * @return DataObjectPagination
     */
    public function paginate(int $page = 1, int $limit = 25, ?iterable $filters = null): DataObjectPagination
    {
        $closure = function ($item) {
            $result = new DictionaryDataObject($item->toArray());
            $result->display_name = json_decode($item->getRawOriginal('display_name'));
            $result->items = $item->items;
            return $result;
        };

        return $this->filterAndPaginate(
            Dictionary::query(),
            $page,
            $limit,
            $closure,
            $filters
        );
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

    /**
     * @param $dictionary
     * @return array
     */
    public function showItems($dictionary){
        $result = [];
        foreach ($dictionary->items as $item){
            $result[] = new DictionaryItemDataObject($item->toArray());
        }
        return $result;
    }


    /**
     * @param $dictionary
     * @return array
     */
    public function showItemsConfs($dictionary){
        $result = [];
        foreach ($dictionary->items as $item){
            $object = new DictionaryConfDataObject($item->toArray());
            $object->confs = $item->tarifConfs;
            $result[] = $object;
        }
        return $result;
    }
}
