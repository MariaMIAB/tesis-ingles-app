<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasFactory,Notifiable,HasRoles,InteractsWithMedia, SoftDeletes;
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
    
    protected $dates = ['deleted_at'];
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
    public function hasDirectOrRolePermission($permission)
    {
        if ($this->hasPermissionTo($permission)) {
            return true;
        }

        foreach ($this->roles as $role) {
            if ($role->hasPermissionTo($permission)) {
                return true;
            }
        }

        return false;
    }

    public function getAvatarUrlAttribute()
    {
        $url = $this->getFirstMediaUrl('avatar');
        $relativePath = parse_url($url, PHP_URL_PATH);
        return $relativePath;
    }

    public function getAvatarThumbUrlAttribute()
    {
        $url = $this->getFirstMediaUrl('avatar', 'thumb');
        $relativePath = parse_url($url, PHP_URL_PATH);
        return $relativePath;
    }

    public function getAvatarMediumUrlAttribute()
    {
        $url = $this->getFirstMediaUrl('avatar', 'medium');
        $relativePath = parse_url($url, PHP_URL_PATH);
        return $relativePath;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(100)
              ->height(100);

        $this->addMediaConversion('medium')
              ->width(300)
              ->height(300);
    }
    
    public function adminlte_image()
    {
        if ($this->hasMedia('avatar')) {
            return $this->avatar_thumb_url;
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
        $userId = Auth::id();
        return route('users.show', ['user' => $userId]);

    }
    public function hasPermissionTo($permission, $guardName = null)
    {
        // Verificar si el usuario tiene el permiso directamente revocado
        if ($this->permissions->contains('name', $permission)) {
            return true;
        }

        // Verificar si el usuario tiene el permiso a través de roles
        return $this->roles->flatMap->permissions->contains('name', $permission);
    }
}