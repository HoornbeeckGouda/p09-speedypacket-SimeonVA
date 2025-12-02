<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRoleNames()
    {
        return $this->roles()->pluck('naam')->toArray();
    }

    public function hasRole($role): bool
    {
        return $this->roles()->where('naam', $role)->exists();
    }

    public function hasAnyRole($roles): bool
    {
        return $this->roles()->whereIn('naam', (array)$roles)->exists();
    }

    public function permissions()
    {
        return $this->roles->flatMap->permissions->unique('id');
    }

    public function hasPermission(string $permission): bool
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('naam', $permission);
        })->exists();
    }

    // ✅ 2FA helpers
    public function regenerateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }

    public function clearTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function getPermissionNames()
    {
        return $this->roles->flatMap->permissions->pluck('naam')->unique()->toArray();
    }

    public function pakkettenAlsOntvanger()
    {
        return $this->hasMany(Pakket::class, 'ontvanger_id');
    }
}
