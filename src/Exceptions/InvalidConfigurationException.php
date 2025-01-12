<?php

namespace AvocetShores\LaravelRewind\Exceptions;

use AvocetShores\LaravelRewind\Exceptions\LaravelRewindException;

class InvalidConfigurationException extends LaravelRewindException
{
    public static function ModelIsNotValid($model): static
    {
        return new static("The model [{$model}] isn't a valid Eloquent model.");
    }
}
