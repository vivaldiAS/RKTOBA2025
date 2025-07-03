<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'jenis_produk' => 'required',
            'nama_produk' => 'required',
            'expired_date' => 'required',
            'deskripsi_produk' => 'required',
            'harga' => 'required',
            'berat' => 'required',
            'jumlah' => 'required',
            'upload_image' => 'required',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Input :attribute tidak boleh kosong',
        ];
    }
}
