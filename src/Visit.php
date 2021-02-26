<?php

namespace Kyranb\Footprints;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{

    /**
     * The name of the database table.
     *
     * @var string
     */
    protected $table = 'visits';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Override constructor to set the table name @ time of instantiation.
     *
     * @param array $attributes
     * @return void
     */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('footprints.table_name'));

        if (config('footprints.connection_name')) {
            $this->setConnection(config('footprints.connection_name'));
        }
    }

    /**
     * Get the account that owns the visit.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        $model = config('footprints.model');

        return $this->belongsTo($model, config('footprints.column_name'));
    }

    /**
     * Scope a query to only include previous visits.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePreviousVisits($query, $footprint)
    {
        return $query->where('footprint', $footprint);
    }

    /**
     * Scope a query to only include previous visits that have been unassigned.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnassignedPreviousVisits($query, $footprint)
    {
        return $query->whereNull(config('footprints.column_name'))->where('footprint', $footprint);
    }
}
