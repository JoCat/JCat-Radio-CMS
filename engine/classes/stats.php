<?php
require_once __DIR__ . '/phpbrowscap/Browscap.php';
require_once ENGINE_DIR . '/classes/db_connect.php';

use phpbrowscap\Browscap;

$browscap = new Browscap(ENGINE_DIR . '/cache/phpbrowscap/');

class Statistics
{
    function __construct()
    {
        global $pdo;
        global $user;
        global $browscap;

        $ip = $_SERVER['REMOTE_ADDR'];

        if ($user->is_user_authed()) {
            if (!isset($_SESSION['count_update']) || $_SESSION['count_update'] != true) {
                $stmt = $pdo->prepare('UPDATE `visit_stats` SET `user`=:user WHERE ip = :ip');
                $stmt->execute([
                    'ip' => $ip,
                    'user' => $user->get('username'),
                ]);
                $_SESSION['count_update'] = true;
            }
        } else {
            if (!isset($_SESSION['count_check']) || $_SESSION['count_check'] != true) {
                $stmt = $pdo->prepare('SELECT * FROM `visit_stats` WHERE ip = :ip AND date = :date');
                $stmt->execute(['ip' => $ip, 'date' => date('Y-m-d')]);
                $result = $stmt->fetch();
                if (empty($result)) {
                    $user_agent = $browscap->getBrowser();
                    $stmt = $pdo->prepare('INSERT INTO `visit_stats`(`ip`, `date`, `user_agent`) VALUES (:ip,:date,:user_agent)');
                    $stmt->execute([
                        'ip' => $ip,
                        'date' => date('Y-m-d'),
                        'user_agent' => json_encode([
                            'browser' => $user_agent->Parent,
                            'platform' => $user_agent->Platform,
                            'device_type' => ($user_agent->isTablet) ? 'tablet' : (($user_agent->isMobileDevice) ? 'mobile' : 'standalone')
                        ]),
                    ]);
                    $_SESSION['count_check'] = true;
                }
            }
        }
    }
}
(new Statistics());
