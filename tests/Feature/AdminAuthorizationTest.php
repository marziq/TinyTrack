<?php

namespace Tests\Feature;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_reject_guests_and_regular_users(): void
    {
        $this->get('/admin/users')->assertRedirect(route('login', absolute: false));
        $this->get('/notifications')->assertRedirect(route('login', absolute: false));

        $this->actingAs(User::factory()->create())
            ->get('/admin/users')
            ->assertForbidden();

        $this->actingAs(User::factory()->create())
            ->get('/notifications')
            ->assertForbidden();
    }

    public function test_admin_role_can_access_admin_routes_and_manage_notifications(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->actingAs($admin)
            ->get('/admin/users')
            ->assertOk();

        $this->actingAs($admin)
            ->post('/notifications', [
                'user_id' => $admin->id,
                'title' => 'Security update',
                'message' => 'An admin-only notification.',
            ])
            ->assertRedirect(route('notifications.index', absolute: false));

        $this->assertDatabaseHas('notifications', [
            'user_id' => $admin->id,
            'title' => 'Security update',
        ]);
    }

    public function test_admin_login_requires_admin_role(): void
    {
        $user = User::factory()->create();

        $this->post('/login-admin', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();

        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->post('/login-admin', [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard-admin', absolute: false));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_users_can_only_manage_their_own_notifications(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $ownNotification = Notification::factory()->create(['user_id' => $user->id]);
        $otherNotification = Notification::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user)
            ->getJson('/api/notifications')
            ->assertOk()
            ->assertJsonCount(1, 'notifications')
            ->assertJsonPath('notifications.0.notification_id', $ownNotification->notification_id);

        $this->actingAs($user)
            ->postJson("/notifications/{$ownNotification->notification_id}/mark-read")
            ->assertOk();

        $this->postJson("/notifications/{$otherNotification->notification_id}/mark-read")
            ->assertNotFound();

        $this->assertDatabaseHas('notifications', [
            'notification_id' => $ownNotification->notification_id,
            'status' => 'read',
        ]);
        $this->assertDatabaseHas('notifications', [
            'notification_id' => $otherNotification->notification_id,
            'status' => 'unread',
        ]);
    }
}
