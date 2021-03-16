<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SettingsArrayRule implements Rule
{
    private string $message;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        info($value);
        foreach ($value as $setting) {
            $requirements = ['id'];

            foreach ($requirements as $requirement) {
                if (!isset($setting[$requirement])) {
                    $this->message = 'The ' . $requirement . ' field is not set';
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
