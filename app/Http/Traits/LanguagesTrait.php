<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\App;


trait LanguagesTrait {

    public function changeLanguage($language) {

        App::setLocale($language);
    }

    public function getCurrentLanguage() {

        return App::getLocale();
    }

}
