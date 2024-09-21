<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('public', function () {
    return true;  
});