<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{

    /**
     * Get value of option specified by key.
     *
     * @param  string  $key
     *
     * @return string Value of the option.
     */
    public static function getValue(string $key): ?string
    {
        $option = Option::where('key', $key)->first();

        if ($option === null)
        {
            return null;
        }

        return $option->value;
    }

    /**
     * Set value of option specified by key.
     *
     * @param  string  $key
     * @param  string  $value
     *
     * @return bool
     */
    public static function setValue(string $key, string $value): bool
    {
        $option = Option::where('key', $key)->firstOrFail();

        $option->value = $value;
        $option->save();

        return $option->value;
    }

}
