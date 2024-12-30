<?php

namespace App\Models;

use App\Concerns\HasAddresses;
use App\Concerns\HasBanks;
use App\Concerns\HasPhones;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;
use MannikJ\Laravel\Wallet\Traits\HasWallet;
use Spatie\Permission\Traits\HasRoles;
use Turahe\Core\Concerns\HasOrganization;
use Turahe\Core\Concerns\HasSettings;
use Turahe\Core\Models\Organization;
use Turahe\Media\HasMedia;
use Turahe\Subscription\Traits\HasPlanSubscriptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasAddresses;
    use HasBanks;
    use HasMedia;
    use HasOrganization;
    use HasPhones;
    use HasPlanSubscriptions;
    use HasRoles;
    use HasSettings;
    use HasUlids;
    use HasWallet;
    use Notifiable;
    use Searchable;
    use SoftDeletes;

    protected $table = 'users';

    protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'phone',
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
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @var string[]
     */
    protected $defaultSettings = [
        'language',
        'timezone',
        'datetime',
    ];

    // settings rules
    /**
     * @var array|string[]
     */
    public array $settingsRules = [
        'datetime' => 'string',
        'language' => 'string|exists:tm_languages,code',
        'timezone' => 'timezone:all',
    ];

    public function toSearchableArray()
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => $this->created_at,

        ];
    }

    /**
     * Get the URL to the user's profile photo.
     */
    public function avatar(): Attribute
    {
        return Attribute::make(get: fn () => $this->hasMedia('photo')
            ? $this->getFirstMediaUrl('photo')
            : $this->defaultProfilePhotoUrl())->shouldCache();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     */
    protected function defaultProfilePhotoUrl(): string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->alias).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get name alias of user
     */
    protected function alias(): Attribute
    {
        return Attribute::get(fn () => name_alias($this->fullName));

    }

    /**
     * Set the full name of user
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(get: fn () => $this->people ? "{$this->people->full_name}" : $this->username)->shouldCache();
    }

    public function isAdmin(): bool
    {
        if ($this->hasAnyRole('super-admin', 'developer')) {
            return true;
        }

        return false;

    }

    public function setActiveWorkspace(Organization $workspace): void
    {
        $this->organizations()->syncWithPivotValues($workspace->getKey(), ['role' => 'ADMIN']);
        $this->settings()->updateOrCreate(
            [
                'key' => 'active_workspace',

            ],
            ['value' => $workspace->getKey()]
        );
    }

    /**
     * @return null
     */
    public function getActiveWorkspace()
    {
        $workspaceId = $this->getSetting('active_workspace');

        if (! $workspaceId) {
            return null;
        }

        return $this->organizations()->where('organization_id', $workspaceId)->first();
    }
}
