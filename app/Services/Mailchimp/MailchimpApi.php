<?php 

namespace App\Services\Mailchimp;

use NZTim\Mailchimp\MailchimpApi as MailchimpApiWrapper;

class MailchimpApi extends MailchimpApiWrapper
{
    public function getList(string $listId): array
    {
        return $this->call('get', '/lists/' . $listId);
    }

    public function getContacts(string $listId, array $options = []): array
    {
        return $this->call('get', '/lists/' . $listId . '/members/', $options);
    }
}
