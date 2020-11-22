<?php

namespace Jenssegers\Date\Traits;

use Jenssegers\Date\Date;

trait DatesTranslator {
    
    /**
     * Get the attribute created_at like a instance of Date
     *
     * @param [type] $created_at
     * @return Jenssegers\Date
     */
    public function getCreatedAtAttribute($created_at)
    {
        return new Date($created_at);
    }

    /**
     * Get the attribute updated_at like a instance of Date
     *
     * @param [type] $updated_at
     * @return Jenssegers\Date
     */
    public function getUpdatedAtAttribute($updated_at)
    {
        return new Date($updated_at);
    }

    /**
     * Get the attribute deleted_at like a instance of Date
     *
     * @param [type] $deleted_at
     * @return Jenssegers\Date
     */
    public function getDeletedAtAttribute($deleted_at)
    {
        return new Date($deleted_at);
    }
}
