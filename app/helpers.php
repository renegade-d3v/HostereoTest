<?php

use App\Models\Language;

if (!function_exists('getLanguageId')) {
    /**
     * @throws Exception
     */
    function getLanguageId()
    {
        return Language::where('locale', app()->getLocale())->first()->id;
    }
}
