<?php

use App\Models\Announcement;
use App\Models\User;

test('redirects guests away from the announcements index', function () {
    /** @var \Tests\TestCase $testCase */
    $testCase = $this;

    $testCase->get(route('announcements.index'))
        ->assertRedirect(route('login'));
});

test('allows an authenticated user to create an announcement', function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();

    /** @var \Tests\TestCase $testCase */
    $testCase = $this;

    $testCase->actingAs($user)
        ->post(route('announcements.store'), [
            'title' => 'Road Closure Notice',
            'body' => 'The road near the barangay hall will be closed tomorrow.',
            'is_published' => '1',
            'is_featured' => '0',
        ])
        ->assertRedirect(route('announcements.index'));

    $announcement = Announcement::query()->first();

    expect($announcement)
        ->not->toBeNull()
        ->and($announcement->user_id)->toBe($user->id)
        ->and($announcement->title)->toBe('Road Closure Notice')
        ->and($announcement->is_published)->toBeTrue()
        ->and($announcement->published_at)->not->toBeNull();
});

test('allows the owner to update an announcement', function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();
    $announcement = Announcement::factory()->for($user)->published()->create();

    /** @var \Tests\TestCase $testCase */
    $testCase = $this;

    $testCase->actingAs($user)
        ->put(route('announcements.update', $announcement), [
            'title' => 'Updated Notice',
            'body' => 'The schedule has changed.',
            'is_published' => '0',
            'is_featured' => '1',
        ])
        ->assertRedirect(route('announcements.index'));

    $announcement->refresh();

    expect($announcement->title)->toBe('Updated Notice')
        ->and($announcement->is_featured)->toBeTrue()
        ->and($announcement->is_published)->toBeFalse()
        ->and($announcement->published_at)->toBeNull();
});

test('allows the owner to delete an announcement', function () {
    /** @var \App\Models\User $user */
    $user = User::factory()->create();
    $announcement = Announcement::factory()->for($user)->create();

    /** @var \Tests\TestCase $testCase */
    $testCase = $this;

    $testCase->actingAs($user)
        ->delete(route('announcements.destroy', $announcement))
        ->assertRedirect(route('announcements.index'));

    $testCase->assertDatabaseMissing('announcements', [
        'id' => $announcement->id,
    ]);
});