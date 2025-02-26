<?php

require '../../vendor/autoload.php';

use Ratchet\App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Yeni bir bağlantı açıldı: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Mesaj alındı: {$msg}\n";

        // Gelen mesajı decode et
        $data = json_decode($msg, true);

        // Eğer aksiyon 'show_student_screen' ise, tüm istemcilere gönder
        if ($data['action'] === 'show_student_screen') {
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    $client->send(json_encode(['action' => 'show_student_screen']));
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Bağlantı kapandı: {$conn->resourceId}\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Hata: {$e->getMessage()}\n";
        $conn->close();
    }
}

$app = new App('localhost', 8080);
$app->route('/signature', new WebSocketServer(), ['*']);
$app->run();