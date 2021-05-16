<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Comment;
use App\Models\GuestComment;
use App\Models\Image;
use App\Models\Publisher;
use App\Models\User;
use App\Observers\AuthorObserver;
use App\Observers\BookObserver;
use App\Observers\CategoryObserver;
use App\Observers\CommentObserver;
use App\Observers\GuestCommentObserver;
use App\Observers\ImageObserver;
use App\Observers\PublisherObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Author::observe(AuthorObserver::class);
        Publisher::observe(PublisherObserver::class);
        Category::observe(CategoryObserver::class);
        Book::observe(BookObserver::class);
        Image::observe(ImageObserver::class);
        Comment::observe(CommentObserver::class);
        GuestComment::observe(GuestCommentObserver::class);
    }
}
