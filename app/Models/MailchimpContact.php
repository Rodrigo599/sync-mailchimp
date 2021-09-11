<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailchimpContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'sendgrid_id',
        'contact_id'
    ];

     /**
     * Get the contact associated
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
