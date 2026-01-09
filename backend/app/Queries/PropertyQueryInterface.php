<?php

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

interface PropertyQueryInterface
{
    public function build(array $filters = []): Builder;
}
