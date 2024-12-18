<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $file_name
 * @property string $disk
 * @property string $mime_type
 * @property int $size
 * @property int|null $record_left
 * @property int|null $record_right
 * @property int|null $record_dept
 * @property int|null $record_ordering
 * @property string|null $parent_id
 * @property string|null $custom_attribute
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $author
 * @property-read \Kalnoy\Nestedset\Collection<int, Media> $children
 * @property-read int|null $children_count
 * @property-read \App\Models\User|null $destroyer
 * @property-read \App\Models\User|null $editor
 * @property-read string $extension
 * @property-read string|null $type
 * @property Media|null $parent
 *
 * @method static \Kalnoy\Nestedset\Collection<int, static> all($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media ancestorsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media ancestorsOf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media applyNestedSetScope(?string $table = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media countErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media defaultOrder(string $dir = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media descendantsAndSelf($id, array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media descendantsOf($id, array $columns = [], $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media fixSubtree($root)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media fixTree($root = null)
 * @method static \Kalnoy\Nestedset\Collection<int, static> get($columns = ['*'])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media getNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media getPlainNodeData($id, $required = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media getTotalErrors()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media hasChildren()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media hasParent()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media isBroken()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media leaves(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media makeGap(int $cut, int $height)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media moveNode($key, $position)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media onlyTrashed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media orWhereAncestorOf(bool $id, bool $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media orWhereDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media orWhereNodeBetween($values)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media orWhereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media ordered(string $direction = 'asc')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media query()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media rebuildSubtree($root, array $data, $delete = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media rebuildTree(array $data, $delete = false, $root = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media reversed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media root(array $columns = [])
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereAncestorOf($id, $andSelf = false, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereAncestorOrSelf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereCreatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereCreatedBy($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereCustomAttribute($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereDeletedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereDeletedBy($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereDescendantOf($id, $boolean = 'and', $not = false, $andSelf = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereDescendantOrSelf(string $id, string $boolean = 'and', string $not = false)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereDisk($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereFileName($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereIsAfter($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereIsBefore($id, $boolean = 'and')
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereIsLeaf()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereIsRoot()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereMimeType($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereName($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereNodeBetween($values, $boolean = 'and', $not = false, $query = null)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereNotDescendantOf($id)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereParentId($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereRecordDept($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereRecordLeft($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereRecordOrdering($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereRecordRight($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereSize($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereUpdatedAt($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media whereUpdatedBy($value)
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media withDepth(string $as = 'depth')
 * @method static \Illuminate\Database\Eloquent\Builder|Media withTrashed()
 * @method static \Kalnoy\Nestedset\QueryBuilder|Media withoutRoot()
 * @method static \Illuminate\Database\Eloquent\Builder|Media withoutTrashed()
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 *
 * @mixin \Eloquent
 */
class Media extends \Turahe\Media\Models\Media
{
    use HasUlids;

    public $dateFormat = 'U';

    /**
     * Get all the products that are assigned this tag.
     */
    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'mediable');
    }
}
