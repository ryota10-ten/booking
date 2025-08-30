<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\User;
use App\Mail\AnnouncementMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminAnnouncementTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_admin_can_access_announcement_page_and_send_email()
    {
        $admin = AdminUser::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $users = User::factory()->count(3)->create();
        $response = $this->actingAs($admin, 'admins')
            ->get(route('announcement.create'));
        $response->assertStatus(200);
        $response->assertSee('お知らせ');
        
        Mail::fake();

        $mailData = [
            'subject' => 'テスト件名',
            'body' => 'テスト本文',
        ];
        $response = $this->actingAs($admin, 'admins')
            ->post(route('announcement.send'), $mailData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'お知らせメールを送信しました。');

        foreach ($users as $user) {
            Mail::assertQueued(AnnouncementMail::class, function ($mail) use ($user, $mailData) {
                return $mail->hasTo($user->email) &&
                    $mail->subjectText === $mailData['subject'] &&
                    $mail->bodyText === $mailData['body'];
            });
        }
    }
}
