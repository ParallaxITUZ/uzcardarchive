<?php

namespace App\ActionData;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

abstract class ActionDataBase implements ActionDataContract
{
    /**
     * @var \Illuminate\Contracts\Validation\Validator
     */
    private $validator;
    /**
     * @var array
     */
    protected array $rules = [];

    /**
     * @throws BindingResolutionException
     */
    public static function createFromArray(array $parameters = []): self
    {
        $instance = app()->make(static::class);

        try {

            $class = new \ReflectionClass(static::class);

            $fields = [];

            foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $reflectionProperty) {
                if ($reflectionProperty->isStatic()) {
                    continue;
                }

                $field = $reflectionProperty->getName();

                $fields[$field] = $reflectionProperty;
            }

            foreach ($fields as $field => $validator) {
                $value = $parameters[$field] ?? $instance->{$field} ?? null;

                $instance->{$field} = $value;

                unset($parameters[$field]);
            }

        } catch (\Exception $exception) {

        }
        return $instance;
    }

    /**
     * @param Request $request
     * @return static
     * @throws ValidationException
     * @throws BindingResolutionException
     */
    public static function createFromRequest(Request $request): self
    {
        $res = static::createFromArray($request->all());
        $res->validate(false);
        return $res;
    }

    /**
     * @param bool $silent
     * @return bool
     * @throws ValidationException
     */
    public function validate(bool $silent = true): bool
    {
        $this->validator = Validator::make($this->all(true), $this->rules, $this->getValidationMessages(), $this->getValidationAttributes());
//        if ($silent) {
//            return !$this->validator->fails();
//        }
        $this->validator->validate();
        return true;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidator(): \Illuminate\Contracts\Validation\Validator
    {
        return $this->validator;
    }

    public function getValidationErrors(): ?MessageBag
    {
        if (is_null($this->validator)) {
            return null;
        }
        return $this->validator->errors();
    }

    protected function getValidationMessages()
    {
        return trans('validation');
    }

    protected function getValidationAttributes()
    {
        return trans('form');
    }

    /**
     * @param bool $trim_nulls
     * @return array
     */
    public function all(bool $trim_nulls = false): array
    {
        $data = [];

        try {
            $class = new \ReflectionClass(static::class);

            $properties = $class->getProperties(\ReflectionProperty::IS_PUBLIC);

            foreach ($properties as $reflectionProperty) {

                if ($reflectionProperty->isStatic()) {
                    continue;
                }

                $value = $reflectionProperty->getValue($this);

                if ($trim_nulls === true) {
                    if (!is_null($value)) {
                        $data[$reflectionProperty->getName()] = $value;
                    }
                } else {
                    $data[$reflectionProperty->getName()] = $value;
                }

            }
        } catch (\Exception $exception) {

        }

        return $data;
    }
}
