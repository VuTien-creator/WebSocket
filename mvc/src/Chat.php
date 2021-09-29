<?php
namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use UserModel;
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once './mvc/core/system/config/config.php';
require_once './mvc/core/system/libs/functions.php';

require_once dirname(__DIR__).'/core/Model.php';
require_once dirname(__DIR__).'/models/UserModel.php';

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        //convert mess json to array
        $data = json_decode($msg, true);

        $user = new UserModel;
        $user->setUserID($data['userId']);

        $userData = $user->getUserDataById();

        $userName = $userData->name;

        //create time
        $data['date'] = date('Y-m-d h:i:s');

        foreach ($this->clients as $client) {
            // if ($from !== $client) {
            //     // The sender is not the receiver, send to each client connected
            //     $client->send($msg);
            // }

            if($from == $client){
                $data['from'] = 'Me';
            }else{
                $data ['from'] = $userName;
            }

            //send message after format
            $client->send(json_encode($data));
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}