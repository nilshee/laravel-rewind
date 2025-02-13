<?php

use AvocetShores\LaravelRewind\Events\RewindVersionCreating;
use AvocetShores\LaravelRewind\Listeners\CreateRewindVersion;
use AvocetShores\LaravelRewind\Tests\Models\Post;
use Illuminate\Cache\PhpRedisLock;
use Illuminate\Contracts\Cache\LockTimeoutException;

it('Logs error when unable to acquire a lock', function () {
    $model = Post::create([
        'user_id' => 1,
        'title' => 'Post Title',
        'body' => 'Post Body',
    ]);

    $lock = \Mockery::mock(PhpRedisLock::class);
    $lock->shouldReceive('block')
        ->once()
        ->andThrow(LockTimeoutException::class);

    $lock->shouldReceive('release')
        ->once();

    // Mock the cache lock to throw an exception
    $cacheSpy = \Illuminate\Support\Facades\Cache::spy();
    $cacheSpy->shouldReceive('lock')
        ->once()
        ->andReturn($lock);

    $listener = new CreateRewindVersion;
    $listener->handle(new RewindVersionCreating($model));
});
