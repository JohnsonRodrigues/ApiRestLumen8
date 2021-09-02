<?php

namespace App\Http\Requests;

use Laravel\Lumen\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\ValidatesWhenResolvedTrait;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

abstract class FormRequest extends Request implements ValidatesWhenResolved
{
    use ValidatesWhenResolvedTrait;

    protected $container;
    protected string $errorBag = 'default';

    protected function getValidatorInstance(): Validator
    {
        $factory = $this->container->make(ValidationFactory::class);

        if (method_exists($this, 'validator')) {
            $validator = $this->container->call([$this, 'validator'], compact('factory'));
        } else {
            $validator = $this->createDefaultValidator($factory);
        }

        if (method_exists($this, 'withValidator')) {
            $this->withValidator($validator);
        }

        return $validator;
    }

    protected function createDefaultValidator(ValidationFactory $factory): Validator
    {
        return $factory->make(
            $this->validationData(), $this->container->call([$this, 'rules']),
            $this->messages(), $this->attributes()
        );
    }

    protected function validationData(): array
    {
        return $this->all();
    }

    protected function failedValidation(Validator $validator): ValidationException
    {
        throw new ValidationException($validator, $this->formatErrors($validator));
    }

    protected function formatErrors(Validator $validator): JsonResponse
    {
        return new JsonResponse($validator->getMessageBag()->toArray(), 422);
    }

    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [];
    }

    public function setContainer(Container $container): FormRequest
    {
        $this->container = $container;

        return $this;
    }

    public function validated(): array
    {
        return $this->getValidatorInstance()->validated();
    }
}
