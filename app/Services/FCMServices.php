<?php

namespace App\Services;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use LaravelFCM\Facades\FCM;

class FCMServices
{
    public function sendToTopic($title, $body, $color, $topicName)
    {
        $notificationBuilder = $this->getNotificationBuilder($title, $body, $color);

        $topic = $this->getTopic($topicName);

        $topicResponse = FCM::sendToTopic($topic, null, $notificationBuilder->build(), null);

        return (Object) [
            'success'     => $topicResponse->isSuccess(),
            'shouldRetry' => $topicResponse->shouldRetry(),
            'error'       => $topicResponse->error(),
        ];
    }

    public function sendTo($title, $body, $color, $token)
    {
        $notificationBuilder = $this->getNotificationBuilder($title, $body, $color);

        $downstreamResponse = FCM::sendTo($token, null, $notificationBuilder->build(), null);

        return (Object) [
            'success'     => $downstreamResponse->numberSuccess(),
            'shouldRetry' => '',
            'error'       => '',
        ];
    }

    private function getNotificationBuilder($title, $body, $color)
    {
        return (new PayloadNotificationBuilder($title))
            ->setBody($body)
            ->setSound('default')
            ->setColor($color);
    }

    private function getTopic($name)
    {
        return (new Topics())->topic($name);
    }
}