<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'cnpj',
        'cep',
        'address',
        'user_id'
    ];

    /**
     * Get the CNPJ with the mask applied.
     */
    public function getCnpjAttribute($value)
    {
        // Apply the mask when displaying the CNPJ
        return $this->applyCnpjMask($value);
    }

    /**
     * Set the CNPJ value without the mask before saving to the database.
     */
    public function setCnpjAttribute($value)
    {
        // Remove the mask before saving the CNPJ
        $this->attributes['cnpj'] = $this->removeCnpjMask($value);
    }

    /**
     * Apply the CNPJ mask to the raw value.
     */
    private function applyCnpjMask($value)
    {
        // Format the CNPJ value using the mask 'XX.XXX.XXX/XXXX-XX'
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $value);
    }

    /**
     * Remove the CNPJ mask to store the raw value.
     */
    private function removeCnpjMask($value)
    {
        // Remove all non-digit characters
        return preg_replace('/\D/', '', $value);
    }

    /**
     * Get the CEP with the mask applied.
     */
    public function getCepAttribute($value)
    {
        // Apply the mask when displaying the CEP
        return $this->applyCepMask($value);
    }

    /**
     * Set the CEP value without the mask before saving to the database.
     */
    public function setCepAttribute($value)
    {
        // Remove the mask before saving the CEP
        $this->attributes['cep'] = $this->removeCepMask($value);
    }

    /**
     * Apply the CEP mask to the raw value.
     */
    private function applyCepMask($value)
    {
        // Format the CEP value using the mask 'XXXXX-XXX'
        return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $value);
    }

    /**
     * Remove the CEP mask to store the raw value.
     */
    private function removeCepMask($value)
    {
        // Remove all non-digit characters (keep only the numbers)
        return preg_replace('/\D/', '', $value);
    }
}
