<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Turahe\Core\Concerns\HasConfigurablePrimaryKey;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Manufacture extends Model
{
    use HasConfigurablePrimaryKey;
    use HasUserStamps;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'manufactures';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'manufacture_id');

    }
}
