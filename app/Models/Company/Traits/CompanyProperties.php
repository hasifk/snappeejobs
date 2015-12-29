<?php

namespace App\Models\Company\Traits;


trait CompanyProperties
{
    public function attachIndustries($industries){
        foreach ($industries as $industry) {
            $this->attachIndustry($industry);
        }
    }

    public function attachIndustry($industry)
    {
        if( is_object($industry))
            $industry = $industry->getKey();

        if( is_array($industry))
            $industry = $industry['id'];

        $this->industries()->attach($industry);
    }
}