<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
       'email',
       'first_name',
       'last_name'
    ];

    /**
     * Get the Sendgrid contact associated
     */
    public function sendgridContact()
    {
        return $this->hasOne(SendgridContact::class);
    }

    /**
     * Get the Mailchimp contact associated
     */
    public function mailchimpContact()
    {
        return $this->hasOne(MailchimpContact::class);
    }
}
