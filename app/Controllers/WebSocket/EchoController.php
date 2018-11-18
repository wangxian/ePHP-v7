<?php
namespace App\Controllers\WebSocket;

use \Swoole\Http\Request;
use \Swoole\WebSocket\Frame;

use \App\Controllers\RootController;

class EchoController extends RootController implements \ePHP\Core\WebSocketInterface
{
    public function index()
    {
        $this->view->render('websocket/index.php');
    }

     /**
     * @param Server $server
     * @param Request $request
     * @return void
     */
    public function onOpen(\Swoole\WebSocket\Server $server, Request $request)
    {
        echo "[websocket][onopen]server: handshake success with fd{$request->fd} url={$request->server['request_uri']}?{$request->server['query_string']}\n";
    }

    /**
     * @param Server $server
     * @param Frame $frame
     * @return void
     */
    public function onMessage(\Swoole\WebSocket\Server $server, Frame $frame)
    {
        echo "[websocket][onmessage]receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $server->push($frame->fd, "this is server");
    }

    /**
     * On connection closed
     *
     * @param Server $server
     * @param int $fd
     * @return void
     */
    public function onClose(\Swoole\WebSocket\Server $server, int $fd)
    {
        echo "[websocket][onclose]client {$fd} closed\n";
    }

}
