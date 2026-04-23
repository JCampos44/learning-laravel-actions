<?php

namespace App\Models;

use App\Enums\V1\TodoStatus;
use App\Policies\V1\TodoPolicy;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['user_id', 'title', 'description', 'status', 'completed_at'])]
#[UsePolicy(TodoPolicy::class)]
class Todo extends Model
{
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => TodoStatus::class,
            'completed_at' => 'datetime',
        ];
    }
    
}
