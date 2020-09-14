<?php

namespace Norge\Ngmap;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Ngmap extends Field {

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'ngmap';

    public function initLocation($latitude, $longitude) {
        return $this->withMeta([
                    'lat' => $latitude,
                    'lng' => $longitude,
        ]);
    }

    //  缩放
    public function zoom($zoom) {
        return $this->withMeta([
                    'zoom' => $zoom
        ]);
    }

    //  图形类型
    public function shapeType($shapeType) {
        return $this->withMeta([
                    'shapetype' => $shapeType
        ]);
    }


    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute) {
        if ($request->exists($requestAttribute)) {
            $model->{$attribute} = json_decode($request[$requestAttribute], true);
        }
    }

}
