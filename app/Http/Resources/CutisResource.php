<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CutisResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id_pegawai' => $this->id_pegawai,
            'name' => $this->name,
            'keterangan' => $this->keterangan,
            'subjek' => $this->subjek,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_akhir' => $this->tanggal_akhir,
        ];
    }
}
