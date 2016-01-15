<?php namespace App\Repositories\Frontend\Company;

use App\Models\Company\Company;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentCompanyRepository {

    public function getCompaniesPaginated($per_page, $order_by = 'companies.id', $sort = 'asc') {

        return Company::with('people','photos','videos','socialmedia','industries')
            ->orderBy($order_by, $sort)
            ->paginate($per_page);

    }

    public function getCompanyBySlug($slug)
    {
        return Company::with('people','photos','videos','socialmedia','industries')
        ->where('companies.url_slug',$slug)->first();
    }

}