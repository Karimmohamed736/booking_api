<?php

namespace App\Services;

class MediaService{
    public function createMedia($file, $model, $collection='images'){
        $model->addMedia($file)->toMediaCollection($collection);
    }
}
