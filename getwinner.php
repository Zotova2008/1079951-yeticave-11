<?php

require_once 'vendor/autoload.php';
require_once 'init.php';

$transport = (new Swift_SmtpTransport('phpdemo.ru', 25))
    ->setUsername('keks@phpdemo.ru')
    ->setPassword('htmlacademy');

$mailer = new Swift_Mailer($transport);

$sql = 'SELECT bet.* FROM bet WHERE id_lot IN (SELECT id FROM lot WHERE date_final < NOW() AND id_user_winner IS NULL) AND bet.bet_sum IN (SELECT MAX(bet.bet_sum) FROM bet GROUP BY id_lot)';
$result = mysqli_query($con, $sql);
$winners = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (count($winners)) {
    foreach ($winners as $winner) {
        mysqli_query($con, 'UPDATE lot SET id_user_winner = ' . $winner['id_user'] . ' WHERE id = ' . $winner['id_lot']);
        $sql = 'SELECT lot.id, lot.lot_title AS lot_title, user_data.user_email, user_data.user_name AS user_name FROM lot JOIN user_data ON lot.id_user = user_data.id WHERE lot.id = ' . $winner['id_lot'];
        $result = mysqli_query($con, $sql);
        $data = mysqli_fetch_assoc($result);
        $mail_content = include_template('email.php', compact('data'));
        $message = (new Swift_Message('Ваша ставка победила'))
            ->setFrom(['keks@phpdemo.ru' => 'YetiCave'])
            ->setTo([$data['user_email'] => $data['user_name']])
            ->setBody($mail_content, 'text/html');
        $result = $mailer->send($message);
    }
}
