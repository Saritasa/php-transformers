<?php

namespace Saritasa\Transformers\Exceptions;

use Saritasa\Transformers\IDataTransformer;

/**
 * Should be thrown, when transformer expects one type of model, but gets another, incompatible model
 */
class TransformTypeMismatchException extends TransformException
{
    /**
     * Should be thrown, when transformer expects one type of model, but gets another, incompatible model
     * @param IDataTransformer $transformer Originator of message
     * @param string $expected_class Class or model, that was expected by transform() method
     * @param string $actual_class Class or model, that was actually given to transform() method
     */
    public function __construct(IDataTransformer $transformer, string $expected_class, string $actual_class)
    {
        $message = trans('transform.model_type_mismatch', compact($expected_class, $actual_class));
        parent::__construct($transformer, $message);
    }
}