<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ChatbotController extends Controller
{
    protected $resourceDir = 'admin.chatbot';
    public function interface(){
        return view($this->resourceDir . '.interface.index');
    }
}
