<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactCollection;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Services\Mailchimp\Mailchimp;
use Exception;
use Illuminate\Support\Arr;
use stdClass;

class ContactController extends Controller
{
    public function sync(Request $request) 
    {

        //Validate Token
        $token = $request->bearerToken() ? $request->bearerToken() : $request->token;
        if($token !== "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9") {
            return response()->json(['error' => 'Not authorized. Use Valid Bearer Token'],403);
        }

        //Retrieve new records of Mailchimp and update DB
        $mailChimp = new Mailchimp(env('MC_KEY'));
        $contacts = Mailchimp::convertContacts($mailChimp->getAllContacts());
        Contact::upsert($contacts, ["mailchimp_id"], ["email", "first_name", "last_name"]);
        Contact::whereNotIn('mailchimp_id',  Arr::pluck($contacts, 'id'))->delete();

        //Get only records not sent to Sendgrid previously
        $contactsToSync = Contact::where("sent", false);

        //Prepare Object to send contacts Contacts to sendgrid
        $sendgrid = new \SendGrid(env('SENDGRID_KEY'));
        $body = new stdClass();
        $body->contacts = $contactsToSync->select("email", "first_name", "last_name")->get()->toArray();

        //Send Contacts to sendgrid and update 'sent' field
        try {
            $response =  $sendgrid->client->marketing()->contacts()->put($body);

            if($response->statusCode() == "202") {
                $contactsToSync->update(["sent" => true]);
            }
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
       
        return new ContactCollection($contactsToSync->get());
    }
}
