<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Turahe\Core\Concerns\HasConfigurablePrimaryKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Turahe\Media\HasMedia;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Brand extends Model
{
    use HasMedia;
    use HasConfigurablePrimaryKey;
    use HasUserStamps;
    use SoftDeletes;


    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    protected function logo(): Attribute
    {
        return new Attribute(fn () => $this->hasMedia('logo') ? $this->getFirstMediaUrl('logo') : null);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'manufacture_id');

    }
}
