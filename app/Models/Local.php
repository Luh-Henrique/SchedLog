<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cep',
        'address',
        'user_id'
    ];

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
