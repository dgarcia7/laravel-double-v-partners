<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use WebSocket\Client as WebSocketClient;

class WsNodeServiceProvider extends ServiceProvider
{
    private $host;
	private $port;
    private $url;

    function __construct()
    {
        $this->host = env('WS_NODE_HOST', "127.0.0.1");
        $this->port = env('WS_NODE_PORT', 3000);
        $this->url = "ws://$this->host:$this->port";
    }

    public function ws($data = []) {
        $client = new WebSocketClient($this->url);
        $client->send(json_encode($data));
        $client->close();

        return response()->json(['message' => 'Success']);
	}
}
