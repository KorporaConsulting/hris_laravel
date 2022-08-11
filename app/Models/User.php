<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function karyawan ()
    {
        return $this->hasOne(Karyawan::class);
    }

    public function kpi ()
    {
        return $this->hasMany(KPI::class);
    }

    public function divisions()
    {
        return $this->belongsToMany(Divisi::class, 'divisi_user', 'user_id', 'divisi_id');
    }

    public function announcements ()
    {
        return $this->belongsToMany(Pengumuman::class, 'pengumuman_user', 'user_id', 'pengumuman_id');
    }

    public function presents (){
        return $this->hasMany(Kehadiran::class);
    }


}
