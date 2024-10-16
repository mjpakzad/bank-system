<?php

namespace Tests\Unit\Notifications;

use App\Models\User;
use App\Notifications\BalanceChangedNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class BalanceChangedNotificationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_balance_changed_notification_is_sent()
    {
        Notification::fake();

        $user = User::factory()->create();

        $user->notify(new BalanceChangedNotification(5000));

        Notification::assertSentTo(
            [$user],
            BalanceChangedNotification::class,
            function ($notification, $channels) use ($user) {
                $this->assertEquals(5000, $notification->getAmount());
                return true;
            }
        );
    }

    public function test_balance_changed_notification_email_content()
    {
        $user = User::factory()->create(['first_name' => 'Mojtaba', 'last_name' => 'Pakzad', 'email' => 'test@example.com', 'mobile' => '09123456789']);

        $notification = new BalanceChangedNotification(5000);

        $mailData = $notification->toMail($user);

        $this->assertEquals(__('messages.email_subject'), $mailData->subject);

        $viewData = $mailData->viewData;

        $this->assertEquals('Mojtaba Pakzad', $viewData['name']);
        $this->assertEquals(5000, $viewData['amount']);
    }
}
