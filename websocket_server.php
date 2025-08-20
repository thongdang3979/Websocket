<?php
/**
 * WebSocket Server for Payment Tracking
 * Place this file in your CI3 root directory
 * Run: php websocket_server.php
 */

require_once 'vendor/autoload.php'; // Install Ratchet via Composer

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\App;

class PaymentSocket implements MessageComponentInterface {
    protected $clients;
    protected $payments;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->payments = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        if (!$data) {
            return;
        }

        switch($data['type']) {
            case 'join_payment':
                // User joins payment room
                $paymentId = $data['payment_id'];
                $from->payment_id = $paymentId;
                $from->client_type = 'user';

                if (!isset($this->payments[$paymentId])) {
                    $this->payments[$paymentId] = [];
                }
                $this->payments[$paymentId][] = $from;

                echo "User joined payment room: {$paymentId}\n";
                break;

            case 'join_admin':
                // Admin joins
                $from->client_type = 'admin';
                echo "Admin connected\n";
                break;

            case 'update_payment':
                // Admin updates payment status
                if ($from->client_type === 'admin') {
                    $paymentId = $data['payment_id'];
                    $status = $data['status'];

                    // Update database
                    $this->updatePaymentInDB($paymentId, $status);

                    // Notify all clients in this payment room
                    if (isset($this->payments[$paymentId])) {
                        foreach ($this->payments[$paymentId] as $client) {
                            if ($client !== $from) {
                                $client->send(json_encode([
                                    'type' => 'payment_updated',
                                    'payment_id' => $paymentId,
                                    'status' => $status,
                                    'timestamp' => date('Y-m-d H:i:s')
                                ]));
                            }
                        }
                    }

                    echo "Payment {$paymentId} updated to {$status}\n";
                }
                break;
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Remove from payment rooms
        if (isset($conn->payment_id)) {
            $paymentId = $conn->payment_id;
            if (isset($this->payments[$paymentId])) {
                $key = array_search($conn, $this->payments[$paymentId]);
                if ($key !== false) {
                    unset($this->payments[$paymentId][$key]);
                }
            }
        }

        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    private function updatePaymentInDB($paymentId, $status) {
        // Simple database connection - adjust according to your CI3 database config
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
            $stmt = $pdo->prepare("UPDATE payments SET status = ?, updated_at = NOW() WHERE payment_id = ?");
            $stmt->execute([$status, $paymentId]);
        } catch (Exception $e) {
            echo "Database error: " . $e->getMessage() . "\n";
        }
    }
}

$app = new App('localhost', 8080);
$app->route('/websocket', new PaymentSocket, array('*'));

echo "WebSocket server started on localhost:8080\n";
$app->run();