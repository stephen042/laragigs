<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'email',
        'logo',
        'tags',
        'website',
        'company',
        'location',
        'description',
        'user_id'
    ];

    public function scopefilter($query, array $filter)
    {
        if ($filter['tag'] ?? false) {
           $query->where('tags', 'like', '%' . request('tag'). '%');
        }

        if ($filter['search'] ?? false) {
           $query->where('title', 'like','%'. request('search') .'%')
           ->orWhere('description', 'like','%'.  request('search').'%')
           ->orWhere('tags', 'like','%'.  request('search').'%')
           ;
        }
        // dd($query);
            
    }

    // Relationship to user 
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
