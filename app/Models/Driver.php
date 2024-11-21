<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cnh',
    ];

    /**
     * Get the CNH with the mask applied.
     */
    public function getCnhAttribute($value)
    {
        // Apply the mask when displaying the CNH
        return $this->applyCnhMask($value);
    }

    /**
     * Set the CNH value without the mask before saving to the database.
     */
    public function setCnhAttribute($value)
    {
        // Remove the mask before saving the CNH
        $this->attributes['cnh'] = $this->removeCnhMask($value);
    }

    /**
     * Apply the CNH mask to the raw value.
     */
    private function applyCnhMask($value)
    {
        // Format the CNH value using the mask 'XXX XXX XXX XX'
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1 $2 $3 $4', $value);
    }

    /**
     * Remove the CNH mask to store the raw value.
     */
    private function removeCnhMask($value)
    {
        // Remove all non-digit characters (keep only the numbers)
        return preg_replace('/\D/', '', $value);
    }
}
