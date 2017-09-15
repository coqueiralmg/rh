<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Utility\Inflector;

class InflectorHelper extends Helper
{
    /**
     * Returns the input lower_case_delimited_string as 'A Human Readable String'.
     * (Underscores are replaced by spaces and capitalized following words.)
     * @param string $value Texto original
     * @return string Texto humanizado
     */
    public function humanize(string $value)
    {
        return Inflector::humanize($value);
    }

}