<?php

namespace Statview\FilamentAuth\Models;

use Laravel\Passport\Client as BaseClient;

class Client extends BaseClient
{
    public function skipsAuthorization()
    {
        return $this->first_party;
    }
}