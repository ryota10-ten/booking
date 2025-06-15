<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;


class CustomVerifyEmail extends BaseVerifyEmail
{

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
                    ->greeting('')
                    ->subject('【Rese】メールアドレス確認のお願い')
                    ->line('ご登録ありがとうございます。以下のボタンからメールアドレスを確認してください。')
                    ->action('メールアドレスを確認する', $verificationUrl)
                    ->line('このメールに心当たりがない場合は、このメールを無視してください。');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
