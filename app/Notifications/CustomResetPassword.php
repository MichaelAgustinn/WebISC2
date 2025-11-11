<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPasswordNotification
{
    public function toMail($notifiable)
    {
        $url = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject('Atur Ulang Kata Sandi Anda | Informatics Study Club')
            ->greeting('Halo Sobat Informatika 👋')
            ->line('Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda di *Informatics Study Club*.')
            ->line('Klik tombol di bawah ini untuk melanjutkan proses pengaturan ulang kata sandi:')
            ->action('Atur Ulang Kata Sandi', $url)
            ->line('Tautan ini hanya berlaku selama 60 menit. Jika Anda tidak meminta pengaturan ulang, abaikan saja email ini.')
            ->salutation('Salam hangat,  
Tim Informatics Study Club');
    }
}
