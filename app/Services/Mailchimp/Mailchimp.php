<?php 

namespace App\Services\Mailchimp;

use Exception;
use NZTim\Mailchimp\Mailchimp as MailchimpWrapper;
use App\Services\Mailchimp\MailchimpApi;
use Illuminate\Support\Arr;

class Mailchimp extends MailchimpWrapper
{
    public function __construct($apikey, $api = null)
    {
        if (!is_string($apikey)) {
            throw new Exception("Mailchimp API key is required - use the 'MC_KEY' .env value");
        }
        if (is_null($api)) {
            $api = new MailchimpApi($apikey);
        }
        $this->api = $api;   
    }

    public function getAllContacts(): array
    {
        $lists = Arr::pluck($this->getLists(), 'id');

        $contacts = [];

        foreach($lists as $list) {
            $contacts = array_merge($contacts, $this->getAllContactsFromList($list));
        }

        return $contacts;
    }

    public function getAllContactsFromList(string $listId): array
    {
        $batchSize = 1000;
        $response = $this->getContacts($listId, ["count" => $batchSize]);
        $contacts = $response["members"];

        if($response["total_items"] <= $batchSize) {
            return $contacts;
        }

        $pages = ceil($response["total_items"] / $batchSize);
        for($i = 1; $i <= $pages; $i++) {
            $offset = $i * $batchSize;
            $contacts = array_merge($contacts, $this->getContacts($listId, ["count" => $batchSize, 'offset' => $offset])["members"]);
        }

        return $contacts; 
    }

    public function getContacts(string $listId, array $options = []): array
    {
        return $this->api->getContacts($listId, $options);
    }

    public static function convertContacts($contacts): array
    {
        return array_map(function($contact) {
            return [
                "mailchimp_id" => $contact["contact_id"],
                "email" => $contact["email_address"],
                "first_name" => $contact["merge_fields"]["FNAME"],
                "last_name" => $contact["merge_fields"]["LNAME"]
            ];
        }, $contacts);
    }
}
