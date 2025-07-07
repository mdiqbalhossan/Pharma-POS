<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $appends = [
        'avatar',
        'role_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'password'          => 'hashed',
        ];
    }

    /**
     * Get the user's avatar as an SVG.
     *
     * @return string
     */
    public function getAvatarAttribute(): string
    {
        // Get the initials from the name
        $nameParts = explode(' ', $this->name);
        $initials  = '';

        if (count($nameParts) >= 2) {
            // Use first letter of first and last name
            $initials = mb_substr($nameParts[0], 0, 1) . mb_substr($nameParts[count($nameParts) - 1], 0, 1);
        } else {
            // If only one name, use the first two letters or just the first letter
            $initials = mb_substr($this->name, 0, min(2, mb_strlen($this->name)));
        }

        $initials = strtoupper($initials);

        // Generate a color based on the name
        $hash       = md5($this->name);
        $hue        = hexdec(substr($hash, 0, 2)) % 360;
        $saturation = 65;
        $lightness  = 60;

        $bgColor = "hsl($hue, {$saturation}%, {$lightness}%)";

        // Create the SVG
        $svg = <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
            <rect width="40" height="40" rx="20" fill="$bgColor" />
            <text x="20" y="25" font-family="Arial, Helvetica, sans-serif" font-size="16" font-weight="bold" fill="white" text-anchor="middle">$initials</text>
        </svg>
        SVG;

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Get the user's role name.
     *
     * @return string
     */
    public function getRoleNameAttribute(): string
    {
        return $this->getRoleNames()->first() ?? 'Admin';
    }

    /**
     * Get the store that the user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function store(): HasOne
    {
        return $this->hasOne(Store::class);
    }
}
