<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Notification;

class SendInactivityReminder extends Command
{
    protected $signature = 'notify:inactive-users';
    protected $description = 'Send inactivity reminder to users who have not logged in for 30 days';

    public function handle()
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $users = User::where('last_login_date', '<=', $oneMonthAgo)->get();

        foreach ($users as $user) {
            $mailMessage = (new MailMessage)
                ->subject('Hello! Your Account is Inactive')
                ->greeting('Hello! ' . $user->name . ',')
                ->line('We have noticed that you have not logged in for 30 days.')
                ->action('Login now and discover our new offers', url('/login'))
                ->line('Thank you for choosing us!')
                ->salutation('Best regards, Royal Crest Family');

            Notification::send($user, $mailMessage);
        }

        $this->info('Emails sent to inactive users.');
    }
}
