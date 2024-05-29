<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasOne;



class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'blocked',
        'photo_filename',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getPhotoFullUrlAttribute()
    {
        if ($this->photo_filename && Storage::exists("public/photos/{$this->photo_filename}")) {
            return asset("storage/photos/{$this->photo_filename}");
        } else {
            // To be changed eventually
            return asset("storage/photos/anonymous.png");
        }
    }

    public function customer(): HasOne //? maybe take it out
    {
        return $this->hasOne(Customer::class, 'customers_id', 'users_id');
    }
}
