<?php namespace App\Repositories\Frontend\Job;

use App\Models\Job\Job;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentJobRepository {

    public function getJobsPaginated($per_page, $order_by = 'jobs.id', $sort = 'asc') {
        return Job::where('status', true)
            ->where('published', true)
            ->orderBy($order_by, $sort)
            ->paginate($per_page);
    }

}