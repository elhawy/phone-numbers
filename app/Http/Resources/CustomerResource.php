<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
private  $countries = [
    "+237" => "Cameroon",
    "+251" => "Ethiopia",
    "+212" => "Morocco",
    "+258" => "Mozambique",
    "+256" => "Uganda",
    ];
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $re = '/\((251)\) ?[1-59]\d{8}$|\((237)\)\ ?[2368]\d{7,8}$|\((256)\)\ ?\d{9}$|\((258)\)\ +?[28]\d{7,8}$|\((212)\)\ ?[5-9]\d{8}$/';
        preg_match($re, $this->phone, $matches, PREG_OFFSET_CAPTURE, 0);
        $phone = explode(" ", $this->phone);
        $code = str_replace(['(', ')'], ['+',''],$phone[0]);
        return [
            'id' => $this->id,
            'phone' => $phone[1] ?? $this->phone,
            'name' => $this->name,
            'code' => $code,
            'status' => !empty($matches) ?  "OK" : "NOK",
            'country' => $this->countries[$code],
        ];
    }
}
