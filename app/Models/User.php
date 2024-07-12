<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

// use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
//  implements FilamentUser
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
        'visible_password',
        'status'
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
        'password'=>'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['Admin', 'Writer']);
    }

    public function canApprove(): bool
    {
        return $this->hasPermissionTo('Approve');
    }

    public function canReject(): bool
    {
        return $this->hasPermissionTo('Reject');
    }

    public function canVerify(): bool
    {
        return $this->hasPermissionTo('Verify');
    }

    public function canView(): bool
    {
        return $this->hasPermissionTo('View');
    }

    public function canEdit(): bool
    {
        return $this->hasPermissionTo('Edit');
    }
    public function getApproveFlowId(): ?int
    {
        $user = Auth::user();
        if ($user->roles?->first()?->id) {
            dd($user->roles?->first());
            return $user->roles?->first()?->id;
        }

        return null;
    }

}
