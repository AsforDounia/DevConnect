<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Container\Attributes\Auth;
use Livewire\Component;

class Like extends Component
{
    public $isLiked;
    public Post $post;
    public function mount(Post $post)
    {
        $this -> post = $post;
        $this -> isLiked =  $this->post->likes()->where('user_id', auth()->id())->first() ? true : false;
    }
    public function toggleLike()
    {
        $like = $this->post->likes()->where('user_id', auth()->id())->first();
        
        if ($like) {
            $like->delete();
            $this -> isLiked = false;
        } else {
            $this ->post->likes()->create([
                'user_id' => auth()->id(),
                'post_id' => $this -> post->id
            ]);
            $this -> isLiked = true;
            if ($this -> post -> user_id !== auth()->id()){
                $this -> post -> user -> notify(new UserNotification('like',auth()->user()->name));
            }
        }
        
        return redirect()->back();
    }
    public function render()
    {
        return view('livewire.like');
    }
}
