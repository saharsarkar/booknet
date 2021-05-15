<?php

namespace App\Observers;

use App\Models\Publisher;
use Illuminate\Support\Facades\Cache;

class PublisherObserver
{
    public function creating(Publisher $publisher)
    {
        Cache::tags(['publishers'])->forget('publisher-list');
    }

    public function updating(Publisher $publisher)
    {
        Cache::tags(['publishers'])->forget('publisher-list');
        Cache::tags(['publishers'])->forget("publisher-{$publisher->id}");
    }

    public function deleting(Publisher $publisher)
    {
        Cache::tags(['publishers'])->forget('publisher-list');
        Cache::tags(['publishers'])->forget("publisher-{$publisher->id}");
    }
}
