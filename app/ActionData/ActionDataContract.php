<?php

namespace App\ActionData;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

interface ActionDataContract
{
    public static function createFromRequest(Request $request);

    public static function createFromArray(array $parameters = []);

    /**
     * @param bool $silent
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(bool $silent = true): bool;

    public function getValidationErrors(): ?MessageBag;

    public function all(bool $trim_nulls = false): array;
}
