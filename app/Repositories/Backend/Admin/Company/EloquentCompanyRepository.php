<?php

namespace App\Repositories\Backend\Admin\Company;

use App\Events\Backend\Company\CompanyUpdated;
use App\Models\Company\Company;
use App\Models\Company\NewCompanyTemp\NewCompanyTemp;
use Illuminate\Http\Request;
use Event;
class EloquentCompanyRepository
{
    public function getCompaniesPaginated($per_page, $order_by = 'companies.id', $sort = 'asc'){
        return Company::orderBy($order_by, $sort)
            ->paginate($per_page);
    }

    public function getNewCompaniesPaginated($per_page, $order_by = 'new_company_temps.created_at', $sort = 'desc'){
        return NewCompanyTemp::where('completed', false)->orderBy($order_by, $sort)
            ->paginate($per_page);
    }

    public function findOrThrowException($id) {

        $company = Company::findOrFail($id);

        return $company;
    }

    public function update(Request $request, $id)
    {

        $company = $this->findOrThrowException($id);

        $this->updateCompanyStub($request, $company);

        if ($company->save()) {

            $this->flushIndustries($request->get('industry_company'), $company);

            $this->flushSocialMedia($request->get('social_media'), $company);

            $this->flushVideos($request->get('video_url'), $company);

            $this->flushPeople(
                $request->get('people_name'),
                $request->get('job_position'),
                $request->get('people_about'),
                $request->get('people_testimonial'),
                $request->get('avatar_image'),
                $request->get('people_id'),
                $request->get('people_delete'),
                [
                    $request->file('people_avatar_0'),
                    $request->file('people_avatar_1'),
                    $request->file('people_avatar_2'),
                    $request->file('people_avatar_3')
                ],
                $company
            );

            $company->attachPhotos([
                $request->file('photo_1'),
                $request->file('photo_2'),
                $request->file('photo_3'),
                $request->file('photo_4')
            ], $request->get('photos_delete'));

            $company->attachLogo($request->file('logo'));
            Event::fire(new CompanyUpdated($company));
            return $company;
        }

        throw new GeneralException('There was a problem creating this user. Please try again.');
    }

    public function create(Request $request, $id){

        $company = new Company();
        $company->employer_id = $id;

        $this->updateCompanyStub($request, $company);

        if ($company->save()) {
            $this->flushIndustries($request->get('industry_company'), $company);

            $this->flushSocialMedia($request->get('social_media'), $company);

            $this->flushVideos($request->get('video_url'), $company);

            $this->flushPeople(
                $request->get('people_name'),
                $request->get('job_position'),
                $request->get('people_about'),
                $request->get('people_testimonial'),
                $request->get('avatar_image'),
                $request->get('people_id'),
                $request->get('people_delete'),
                [
                    $request->file('people_avatar_0'),
                    $request->file('people_avatar_1'),
                    $request->file('people_avatar_2'),
                    $request->file('people_avatar_3')
                ],
                $company
            );

            $company->attachPhotos([
                $request->file('photo_1'),
                $request->file('photo_2'),
                $request->file('photo_3'),
                $request->file('photo_4')
            ], $request->get('photos_delete'));

            $company->attachLogo($request->file('logo'));

            $newCompanyTemp = NewCompanyTemp::where('employer_id', $id)->first();

            $newCompanyTemp->completed = true;

            $newCompanyTemp->save();

            return $company;

        }

    }

    public function updateCompanyStub($input, $company){
        $company->title            = $input['title'];
        $company->url_slug         = str_slug($input['title'], '-');
        $company->size             = $input['size'];
        $company->description      = $input['description'];
        $company->what_it_does     = $input['what_it_does'];
        $company->office_life      = $input['office_life'];
        $company->country_id       = $input['country_id'];
        $company->state_id         = $input['state_id'];
        return $company;
    }

    private function flushIndustries($industries, $company) {
        $company->detachIndustries($company->industries);
        $company->attachIndustries($industries);
    }

    private function flushSocialMedia($socialmedia, $company) {
        $company->detachSocialMedia($company->socialmedia);
        $company->attachSocialMedia($socialmedia);
    }

    private function flushVideos($videos, $company) {
        $company->detachVideos($company->videos);
        $company->attachVideos($videos);
    }

    private function flushPeople(
        $people_names, $job_positions, $people_about, $people_testimonial, $avatar_image, $people_id, $people_delete, $people_avatars, $company
    ) {
        $company->detachPeople($company->people);
        $company->attachPeople($people_names, $job_positions, $people_about, $people_testimonial, $avatar_image, $people_id, $people_delete, $people_avatars);
    }

}
