<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ResourceIntereses extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = array();

        $fechaRegistro = new Carbon($this->created_at);
        $fechaActuali = new Carbon($this->updated_at);

        $resource["identificador"] = $this->id;
        $resource["interes"] = $this->interes;
        $resource["registro"] = $fechaRegistro->format("d-m-Y")." a las ".$fechaRegistro->format("h:i:s");
        $resource["actualizado"] = $fechaActuali->format("d-m-Y")." a las ".$fechaActuali->format("h:i:s");

        return $resource;

    }
}
