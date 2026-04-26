<?php

namespace App\Services;

class MediaService{

    //create media for a model
    public function createMedia($file, $model, $collection='images'){
        
        $model->addMedia($file)->toMediaCollection($collection);
    }


    //update media by deleting old one and adding new one
    public function updateMedia($file, $model, $collection='images'){
        //delete old media
        if ($model->getMedia($collection)->isNotEmpty()) {
            $model->clearMediaCollection($collection);
        }

        return $model->addMedia($file)->toMediaCollection($collection);

    }

    //delete all media of the model
    public function deleteMedia($model, $collection='images'){
        if ($model->getMedia($collection)->isNotEmpty()) {
            $model->clearMediaCollection($collection);
        }
    }


}
