<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasFactory,Notifiable,HasRoles,InteractsWithMedia;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function registerMediaCollections(): void {
        $this
            ->addMediaCollection('avatar')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('small')
                    ->crop('crop-center', 50, 50)
                    ->sharpen(10);
                $this
                    ->addMediaConversion('medium')
                    ->crop('crop-center', 250, 250);
            });
    }

    public function adminlte_image()
    {
        if ($this->hasMedia('avatars')) {
            return $this->getFirstMediaUrl('avatars', 'thumb');
        } else {
            return asset('storage/imagenes/sistema/user.png');
        }
    }

    public function adminlte_desc()
    {
        $user = auth()->user();
        if ($user && $user->roles->count() > 0) {
            $rol = $user->roles->first()->name;
            return $rol;
        } else {
            return "Rol no definido";
        }
    }

    public function adminlte_profile_url()
    {
        return 'profile/username';
    }

}
