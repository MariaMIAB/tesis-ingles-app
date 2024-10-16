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
        return $this->hasPermissionTo($permission) || $this->roles->contains(function ($role) use ($permission) {
            return $role->hasPermissionTo($permission);
        });
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
        if ($this->roles->isNotEmpty()) {
            return $this->roles->first()->name;
        }
    
        return "Rol no definido";
    }

    public function adminlte_profile_url()
    {
        $userId = Auth::id();
        return route('users.show', ['user' => $userId]);

    }
    public function hasPermissionTo($permission, $guardName = null)
    {
        if ($this->permissions->contains('name', $permission)) {
            return true;
        }

        return $this->roles->flatMap->permissions->contains('name', $permission);
    }

     // Relación muchos a muchos con Year
    public function years()
    {
        return $this->belongsToMany(Year::class, 'student_year', 'student_id', 'year_id');
    }

    // Relación muchos a muchos con Semester
    public function semesters()
    {
        return $this->belongsToMany(Semester::class, 'student_semester', 'student_id', 'semester_id');
    }
}