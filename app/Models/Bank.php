<?php

declare(strict_types=1);

namespace App\Models;

use Turahe\Core\Concerns\HasConfigurablePrimaryKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Turahe\UserStamps\Concerns\HasUserStamps;

class Bank extends Model
{
    use HasConfigurablePrimaryKey;
    use HasUserStamps;
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'holder_type',
        'holder_id',
        'bank_id',
        'label',
        'branch_name',
        'branch_code',
        'account_holder',
        'account_number',
        'note',
    ];

    public function holder(): MorphTo
    {
        return $this->morphTo();
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(\Turahe\Master\Models\Bank::class, 'bank_id', 'code');
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(
            Category::class,
            'model',
            'model_has_taxonomies',
            'taxonomy_id',
            'model_id'
        );
    }
}
