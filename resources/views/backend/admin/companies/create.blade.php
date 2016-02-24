@extends ('backend.layouts.master')

@section ('title', 'Admin Create Company Details')

@section('page-header')
    <h1>
        Create Company Profile
    </h1>
@endsection

@section('content')

    @include('backend.admin.includes.partials.company.header-buttons')

    <form method="POST" action="{{ route('admin.company.store', $employer_id) }}" accept-charset="UTF-8" class="form-horizontal" role="form" enctype="multipart/form-data">

    {{ csrf_field() }}

    <div class="form-group">
        {!! Form::label('name', 'Title', ['class' => 'col-lg-2 control-label']) !!}
        <div class="col-lg-10">
            {!! Form::text('title',
            old("title") ? old("title") : ( $company ? $company->title : '' ),
            ['class' => 'form-control',
            'placeholder' => 'Title']) !!}
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">Company Size</label>
        <div class="col-lg-3">
            <div class="checkbox">
                <input
                        type="radio"
                        name="size"
                        id="size_small"
                        value="small" {{
                            old('size') ?
                            old('size') == 'small' ? 'checked="checked"' : ''
                                :
                            $company && $company->size == 'small' ? 'checked="checked"' : ''
                        }}
                />
                <label for="size_small">Small</label>
            </div>
            <div class="checkbox">
                <input
                        type="radio"
                        name="size"
                        id="size_medium"
                        value="medium" {{
                            old('size') ?
                            old('size') == 'medium' ? 'checked="checked"' : ''
                                :
                            $company && $company->size == 'medium' ? 'checked="checked"' : ''
                        }}
                />
                <label for="size_medium">Medium</label>
            </div>
            <div class="checkbox">
                <input
                        type="radio"
                        name="size"
                        id="size_big"
                        value="big" {{
                            old('size') ?
                            old('size') == 'big' ? 'checked="checked"' : ''
                                :
                            $company && $company->size == 'big' ? 'checked="checked"' : ''
                        }}
                />
                <label for="size_big">Big</label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">Industry</label>
        <div class="col-lg-10">
            @if (count($industries) > 0)
                @foreach($industries as $industry)
                    <input
                            type="checkbox"
                            value="{{$industry->id}}"
                            name="industry_company[]"
                            id="industry_company-{{$industry->id}}"
                            {{ old('industry_company')
                                && in_array($industry->id, old('industry_company')) ? 'checked="checked"' : '' }}
                            {{ !old('industry_company') && ( $company && $company->industries)
                                && in_array($industry->id, array_pluck($company->industries->toArray(), 'id')) ? 'checked="checked"' : '' }}
                    />
                    <label for="industry_company-{{$industry->id}}">
                        {!! $industry->name !!}
                    </label>
                    <br/>
                @endforeach
            @endif
        </div>
    </div>
    <?php $social_media_old = old('social_media') ?>
    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">Social Media Links</label>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <label for="social_media_twitter" class="col-lg-2">Twitter</label>
                    <input
                            name="social_media[]"
                            type="text"
                            class="col-lg-10"
                            value="{{ $social_media_old[0] ? $social_media_old[0] : ( ( $company && $company->socialmedia->count() > 0 ) && $company->socialmedia->first()->url ?
                            $company->socialmedia->first()->url : '' ) }}"
                    >
                    <br><br>
                    <label for="social_media_facebook" class="col-lg-2">Facebook</label>
                    <input
                            name="social_media[]"
                            type="text"
                            class="col-lg-10"
                            value="{{ $social_media_old[1] ? $social_media_old[1] : ( ( $company && $company->socialmedia->count() > 1 ) && $company->socialmedia()->skip(1)->take(1)->first()->url ?
                            $company->socialmedia()->skip(1)->take(1)->first()->url : '' ) }}"
                    >
                    <br><br>
                    <label for="social_media_instagram" class="col-lg-2">Instagram</label>
                    <input
                            name="social_media[]"
                            type="text"
                            class="col-lg-10"
                            value="{{ $social_media_old[2] ? $social_media_old[2] : ( ( $company && $company->socialmedia->count() > 2 ) && $company->socialmedia()->skip(2)->take(1)->first()->url ?
                            $company->socialmedia()->skip(2)->take(1)->first()->url : '' ) }}"
                    >
                    <br><br>
                    <label for="social_media_pinterest" class="col-lg-2">Pinterest</label>
                    <input
                            name="social_media[]"
                            type="text"
                            class="col-lg-10"
                            value="{{ $social_media_old[3] ? $social_media_old[3] : ( ( $company && $company->socialmedia->count() > 3 ) && $company->socialmedia()->skip(3)->take(1)->first()->url ?
                            $company->socialmedia()->skip(3)->take(1)->first()->url : '' ) }}"
                    >
                </div>
            </div>
        </div>
    </div>

    <?php $video_url = old('video_url') ?>
    <div class="form-group">
        <label for="video_url_1" class="col-lg-2 control-label">Video URL(s)</label>
        <div class="col-lg-10">
            <input
                    id="video_url_1"
                    name="video_url[]"
                    type="text"
                    class="form-control"
                    value="{{ $video_url[0] ? $video_url[0] : ( ( $company && $company->videos->count() > 0 ) &&
                            $company->videos->first()->url ?
                            $company->videos->first()->url : '' ) }}"
            >
        </div>
    </div>

    <?php $people_name          = old('people_name') ?>
    <?php $job_position         = old('job_position') ?>
    <?php $people_about         = old('people_about') ?>
    <?php $people_testimonial   = old('people_testimonial') ?>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">People</label>
        <div class="col-md-10">
            <div class="row">
                @if(( $company && $company->people->count() > 0 ))
                    <div class="col-md-12">
                        <label for="people_delete_1" class="col-lg-2">
                            Delete this person
                        </label>
                        <div class="col-md-10">
                            <input type="checkbox" value="{{ $company->people->first()->id }}" name="people_delete[]" id="people_delete_1" >
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <label for="people_avatar_1" class="col-lg-2">
                        Avatar
                    </label>
                    <div class="col-md-10">
                        <input
                                type="file"
                                class="form-control"
                                name="people_avatar_0"
                                id="people_avatar_1"
                                placeholder="People Photo"
                        >
                        <input type="hidden" name="people_id[]" value="{{
                        ( $company && $company->people->count() > 0 ) ? $company->people->first()->id : ''
                        }}">
                        <input type="hidden" name="avatar_image[]" value="{{
                        ( $company && $company->people->count() > 0 ) ? $company->people->first()->id : ''
                        }}">
                    </div>
                </div>
                @if (( $company && $company->people->count() > 0 ) &&
                            ( $company->people->first()->path &&
                            $company->people->first()->filename &&
                            $company->people->first()->extension
                            ))
                    <div class="col-md-12">
                        <label for="people_avatar_1" class="col-lg-2">
                            Thumbnail
                        </label>
                        <div class="col-md-10">
                            {!! '<img style="height: 25px; width: 25px;" src="'. $company->people->first()->image .'" alt="'.$company->people->first()->filename.'">' !!}
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <label for="people_name_1" class="col-lg-2">
                        Name
                    </label>
                    <div class="col-md-10">
                        <input
                                type="text"
                                class="form-control"
                                name="people_name[]"
                                id="people_name_1"
                                placeholder="Name"
                                value="{{ $people_name[0] ? $people_name[0] : ( ( $company && $company->people->count() > 0 ) &&
                            $company->people->first()->name ?
                            $company->people->first()->name : '' ) }}"
                        >
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="job_position_1" class="col-lg-2">
                        Job Position
                    </label>
                    <div class="col-md-10">
                        <input
                                type="text"
                                class="form-control"
                                name="job_position[]"
                                id="job_position_1"
                                placeholder="Job Position"
                                value="{{ $job_position[0] ? $job_position[0] : ( ( $company && $company->people->count() > 0 ) &&
                            $company->people->first()->designation ?
                            $company->people->first()->designation : '' ) }}"
                        >
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="people_about_1" class="col-lg-2">
                        About
                    </label>
                    <div class="col-md-10">
                        <textarea class="form-control"
                                  name="people_about[]"
                                  id="people_about_1"
                                  placeholder="About"
                                  cols="30"
                                  rows="10"
                        >{{ $people_about[0] ? $people_about[0] : ( ( $company && $company->people->count() > 0 ) &&
                            $company->people->first()->about_me ?
                            $company->people->first()->about_me : '' ) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="people_testimonial_1" class="col-lg-2">
                        Testimonial
                    </label>
                    <div class="col-md-10">
                        <textarea class="form-control"
                                  name="people_testimonial[]"
                                  id="people_testimonial_1"
                                  placeholder="Testimonial"
                                  cols="30"
                                  rows="10"
                        >{{ $people_testimonial[0] ? $people_testimonial[0] : ( ( $company && $company->people->count() > 0 ) &&
                            $company->people->first()->testimonial ?
                            $company->people->first()->testimonial : '' ) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">&nbsp;</div>
                @if(( $company && $company->people->count() > 1 ))
                    <div class="col-md-12">
                        <label for="people_delete_2" class="col-lg-2">
                            Delete this person
                        </label>
                        <div class="col-md-10">
                            <input type="checkbox" value="{{ $company->people()->skip(1)->take(1)->first()->id }}" name="people_delete[]" id="people_delete_2" >
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <label for="people_avatar_2" class="col-lg-2">
                        Avatar
                    </label>
                    <div class="col-md-10">
                        <input
                                type="file"
                                class="form-control"
                                name="people_avatar_1"
                                id="people_avatar_2"
                                placeholder="People Photo"
                        >
                        <input type="hidden" name="people_id[]" value="{{
                        ( $company && $company->people->count() > 1 ) ? $company->people()->skip(1)->take(1)->first()->id : ''
                        }}">
                        <input type="hidden" name="avatar_image[]" value="{{
                        ( $company && $company->people->count() > 1 ) ? $company->people()->skip(1)->take(1)->first()->id : ''
                        }}">
                    </div>
                </div>
                @if (( $company && $company->people->count() > 1 ) &&
                        ( $company->people()->skip(1)->take(1)->first()->path &&
                                $company->people()->skip(1)->take(1)->first()->filename &&
                                $company->people()->skip(1)->take(1)->first()->extension
                        ))
                    <div class="col-md-12">
                        <label for="people_avatar_1" class="col-lg-2">
                            Thumbnail
                        </label>
                        <div class="col-md-10">
                            {!! '<img style="height: 25px; width: 25px;" src="'.
                                    $company->people()->skip(1)->take(1)->first()->image
                                    .'" alt="'.$company->people()->skip(1)->take(1)->first()->filename.'">' !!}
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <label for="people_name_2" class="col-lg-2">
                        Name
                    </label>
                    <div class="col-md-10">
                        <input
                                type="text"
                                class="form-control"
                                name="people_name[]"
                                id="people_name_2"
                                placeholder="Name"
                                value="{{ $people_name[1] ? $people_name[1] : ( ( $company && $company->people->count() > 1 ) &&
                            $company->people()->skip(1)->take(1)->first()->name ?
                            $company->people()->skip(1)->take(1)->first()->name : '' ) }}"
                        >
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="job_position_2" class="col-lg-2">
                        Job Position
                    </label>
                    <div class="col-md-10">
                        <input
                                type="text"
                                class="form-control"
                                name="job_position[]"
                                id="job_position_2"
                                placeholder="Job Position"
                                value="{{ $job_position[1] ? $job_position[1] : ( ( $company && $company->people->count() > 1 ) &&
                            $company->people()->skip(1)->take(1)->first()->designation ?
                            $company->people()->skip(1)->take(1)->first()->designation : '' ) }}"
                        >
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="people_about_2" class="col-lg-2">
                        About
                    </label>
                    <div class="col-md-10">
                        <textarea class="form-control"
                                  name="people_about[]"
                                  id="people_about_2"
                                  placeholder="About"
                                  cols="30"
                                  rows="10"
                        >{{ $people_about[1] ? $people_about[1] : ( ( $company && $company->people->count() > 1 ) &&
                            $company->people()->skip(1)->take(1)->first()->about_me ?
                            $company->people()->skip(1)->take(1)->first()->about_me : '' ) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="people_testimonial_2" class="col-lg-2">
                        Testimonial
                    </label>
                    <div class="col-md-10">
                        <textarea class="form-control"
                                  name="people_testimonial[]"
                                  id="people_testimonial_2"
                                  placeholder="Testimonial"
                                  cols="30"
                                  rows="10"
                        >{{ $people_testimonial[1] ? $people_testimonial[1] : ( ( $company && $company->people->count() > 1 ) &&
                            $company->people()->skip(1)->take(1)->first()->testimonial ?
                            $company->people()->skip(1)->take(1)->first()->testimonial : '' ) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">&nbsp;</div>
                @if(( $company && $company->people->count() > 2 ))
                    <div class="col-md-12">
                        <label for="people_delete_3" class="col-lg-2">
                            Delete this person
                        </label>
                        <div class="col-md-10">
                            <input type="checkbox" value="{{ $company->people()->skip(2)->take(1)->first()->id }}" name="people_delete[]" id="people_delete_3" >
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <label for="people_avatar_3" class="col-lg-2">
                        Avatar
                    </label>
                    <div class="col-md-10">
                        <input
                                type="file"
                                class="form-control"
                                name="people_avatar_2"
                                id="people_avatar_3"
                                placeholder="People Photo"
                        >
                        <input type="hidden" name="people_id[]" value="{{
                        ( $company && $company->people->count() > 2 ) ? $company->people()->skip(2)->take(1)->first()->id : ''
                        }}">
                        <input type="hidden" name="avatar_image[]" value="{{
                        ( $company && $company->people->count() > 2 ) ? $company->people()->skip(2)->take(1)->first()->id : ''
                        }}">
                    </div>
                </div>
                @if (( $company && $company->people->count() > 2 ) &&
                        ( $company->people()->skip(2)->take(1)->first()->path &&
                                $company->people()->skip(2)->take(1)->first()->filename &&
                                $company->people()->skip(2)->take(1)->first()->extension
                        ))
                    <div class="col-md-12">
                        <label for="people_avatar_1" class="col-lg-2">
                            Thumbnail
                        </label>
                        <div class="col-md-10">
                            {!! '<img style="height: 25px; width: 25px;" src="'.
                                    $company->people()->skip(2)->take(1)->first()->image
                                    .'" alt="'.$company->people()->skip(2)->take(1)->first()->filename.'">' !!}
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <label for="people_name_3" class="col-lg-2">
                        Name
                    </label>
                    <div class="col-md-10">
                        <input
                                type="text"
                                class="form-control"
                                name="people_name[]"
                                id="people_name_3"
                                placeholder="Name"
                                value="{{ $people_name[2] ? $people_name[2] : ( ( $company && $company->people->count() > 2 ) &&
                            $company->people()->skip(2)->take(1)->first()->name ?
                            $company->people()->skip(2)->take(1)->first()->name : '' ) }}"
                        >
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="job_position_3" class="col-lg-2">
                        Job Position
                    </label>
                    <div class="col-md-10">
                        <input
                                type="text"
                                class="form-control"
                                name="job_position[]"
                                id="job_position_3"
                                placeholder="Job Position"
                                value="{{ $job_position[2] ? $job_position[2] : ( ( $company && $company->people->count() > 2 ) &&
                            $company->people()->skip(2)->take(1)->first()->designation ?
                            $company->people()->skip(2)->take(1)->first()->designation : '' ) }}"
                        >
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="people_about_3" class="col-lg-2">
                        About
                    </label>
                    <div class="col-md-10">
                        <textarea class="form-control"
                                  name="people_about[]"
                                  id="people_about_3"
                                  placeholder="About"
                                  cols="30"
                                  rows="10"
                        >{{ $people_about[2] ? $people_about[2] : ( ( $company && $company->people->count() > 2 ) &&
                            $company->people()->skip(2)->take(1)->first()->about_me ?
                            $company->people()->skip(2)->take(1)->first()->about_me : '' ) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="people_testimonial_3" class="col-lg-2">
                        Testimonial
                    </label>
                    <div class="col-md-10">
                        <textarea class="form-control"
                                  name="people_testimonial[]"
                                  id="people_testimonial_3"
                                  placeholder="Testimonial"
                                  cols="30"
                                  rows="10"
                        >{{ $people_testimonial[2] ? $people_testimonial[2] : ( ( $company && $company->people->count() > 2 ) &&
                            $company->people()->skip(2)->take(1)->first()->testimonial ?
                            $company->people()->skip(2)->take(1)->first()->testimonial : '' ) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">&nbsp;</div>
                @if(( $company && $company->people->count() > 3 ))
                    <div class="col-md-12">
                        <label for="people_delete_4" class="col-lg-2">
                            Delete this person
                        </label>
                        <div class="col-md-10">
                            <input type="checkbox" value="{{ $company->people()->skip(3)->take(1)->first()->id }}" name="people_delete[]" id="people_delete_4" >
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <label for="people_avatar_4" class="col-lg-2">
                        Avatar
                    </label>
                    <div class="col-md-10">
                        <input
                                type="file"
                                class="form-control"
                                name="people_avatar_3"
                                id="people_avatar_4"
                                placeholder="People Photo"
                        >
                        <input type="hidden" name="people_id[]" value="{{
                        ( $company && $company->people->count() > 3 ) ? $company->people()->skip(3)->take(1)->first()->id : ''
                        }}">
                        <input type="hidden" name="avatar_image[]" value="{{
                        ( $company && $company->people->count() > 3 ) ? $company->people()->skip(3)->take(1)->first()->id : ''
                        }}">
                    </div>
                </div>
                @if (( $company && $company->people->count() > 3 ) &&
                        ( $company->people()->skip(3)->take(1)->first()->path &&
                                $company->people()->skip(3)->take(1)->first()->filename &&
                                $company->people()->skip(3)->take(1)->first()->extension
                        ))
                    <div class="col-md-12">
                        <label for="people_avatar_1" class="col-lg-2">
                            Thumbnail
                        </label>
                        <div class="col-md-10">
                            {!! '<img style="height: 25px; width: 25px;" src="'.
                                    $company->people()->skip(3)->take(1)->first()->image
                                    .'" alt="'.$company->people()->skip(3)->take(1)->first()->filename.'">' !!}
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <label for="people_name_4" class="col-lg-2">
                        Name
                    </label>
                    <div class="col-md-10">
                        <input
                                type="text"
                                class="form-control"
                                name="people_name[]"
                                id="people_name_4"
                                placeholder="Name"
                                value="{{ $people_name[3] ? $people_name[3] : ( ( $company && $company->people->count() > 3 ) &&
                            $company->people()->skip(3)->take(1)->first()->name ?
                            $company->people()->skip(3)->take(1)->first()->name : '' ) }}"
                        >
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="job_position_4" class="col-lg-2">
                        Job Position
                    </label>
                    <div class="col-md-10">
                        <input
                                type="text"
                                class="form-control"
                                name="job_position[]"
                                id="job_position_4"
                                placeholder="Job Position"
                                value="{{ $job_position[3] ? $job_position[3] : ( ( $company && $company->people->count() > 3 ) &&
                            $company->people()->skip(3)->take(1)->first()->designation ?
                            $company->people()->skip(3)->take(1)->first()->designation : '' ) }}"
                        >
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="people_about_4" class="col-lg-2">
                        About
                    </label>
                    <div class="col-md-10">
                        <textarea class="form-control"
                                  name="people_about[]"
                                  id="people_about_4"
                                  placeholder="About"
                                  cols="30"
                                  rows="10"
                        >{{ $people_about[3] ? $people_about[3] : ( ( $company && $company->people->count() > 3 ) &&
                            $company->people()->skip(3)->take(1)->first()->about_me ?
                            $company->people()->skip(3)->take(1)->first()->about_me : '' ) }}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="people_testimonial_4" class="col-lg-2">
                        Testimonial
                    </label>
                    <div class="col-md-10">
                        <textarea class="form-control"
                                  name="people_testimonial[]"
                                  id="people_testimonial_4"
                                  placeholder="Testimonial"
                                  cols="30"
                                  rows="10"
                        >{{ $people_testimonial[3] ? $people_testimonial[3] : ( ( $company && $company->people->count() > 3 ) &&
                            $company->people()->skip(3)->take(1)->first()->testimonial ?
                            $company->people()->skip(3)->take(1)->first()->testimonial : '' ) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="photo_1" class="col-lg-2 control-label">Photo 1</label>
        <div class="col-lg-5">
            <input
                    type="file"
                    class="form-control"
                    name="photo_1"
                    id="photo_1"
                    placeholder="Company Photo 1"
            >
        </div>
        @if(( $company && $company->photos->count() > 0 ))
            <div class="col-lg-5">
                {!! '<img style="height: 25px; width: 25px;" src="'.
                                $company->photos()->first()->image
                                .'" alt="'.$company->photos()->first()->filename.'">' !!}
                <input
                        type="checkbox"
                        value="{{ $company->photos()->first()->id }}"
                        name="photos_delete[]"
                        id="photos_delete_1"
                >
                <label for="people_delete_1">
                    Delete ?
                </label>
            </div>

        @endif
    </div>

    <div class="form-group">
        <label for="photo_2" class="col-lg-2 control-label">Photo 2</label>
        <div class="col-lg-5">
            <input
                    type="file"
                    class="form-control"
                    name="photo_2"
                    id="photo_2"
                    placeholder="Company Photo 2"
            >
        </div>
        @if(( $company && $company->photos->count() > 1 ))
            <div class="col-lg-5">
                {!! '<img style="height: 25px; width: 25px;" src="'.
                                $company->photos()->skip(1)->take(1)->first()->image
                                .'" alt="'.$company->photos()->skip(1)->take(1)->first()->filename.'">' !!}
                <input
                        type="checkbox"
                        value="{{ $company->photos()->skip(1)->take(1)->first()->id }}"
                        name="photos_delete[]"
                        id="photos_delete_2"
                >
                <label for="people_delete_2">
                    Delete ?
                </label>
            </div>
        @endif
    </div>

    <div class="form-group">
        <label for="photo_3" class="col-lg-2 control-label">Photo 3</label>
        <div class="col-lg-5">
            <input
                    type="file"
                    class="form-control"
                    name="photo_3"
                    id="photo_3"
                    placeholder="Company Photo 3"
            >
        </div>
        @if(( $company && $company->photos->count() > 2 ))
            <div class="col-lg-5">
                {!! '<img style="height: 25px; width: 25px;" src="'.
                                $company->photos()->skip(2)->take(1)->first()->image
                                .'" alt="'.$company->photos()->skip(2)->take(1)->first()->filename.'">' !!}
                <input
                        type="checkbox"
                        value="{{ $company->photos()->skip(2)->take(1)->first()->id }}"
                        name="photos_delete[]"
                        id="photos_delete_3"
                >
                <label for="people_delete_3">
                    Delete ?
                </label>
            </div>
        @endif
    </div>

    <div class="form-group">
        <label for="photo_4" class="col-lg-2 control-label">Photo 4</label>
        <div class="col-lg-5">
            <input
                    type="file"
                    class="form-control"
                    name="photo_4"
                    id="photo_4"
                    placeholder="Company Photo 4"
            >
        </div>
        @if(( $company && $company->photos->count() > 3 ))
            <div class="col-lg-5">
                {!! '<img style="height: 25px; width: 25px;" src="'.
                                $company->photos()->skip(3)->take(1)->first()->image
                                .'" alt="'.$company->photos()->skip(3)->take(1)->first()->filename.'">' !!}
                <input
                        type="checkbox"
                        value="{{ $company->photos()->skip(3)->take(1)->first()->id }}"
                        name="photos_delete[]"
                        id="photos_delete_4"
                >
                <label for="people_delete_4">
                    Delete ?
                </label>
            </div>
        @endif
    </div>

    <div class="form-group">
        <label for="logo" class="col-lg-2 control-label">Logo</label>
        <div class="col-lg-10">
            <input
                    class="form-control"
                    type="file"
                    name="logo"
                    id="logo"
            >
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-lg-2 control-label">Description</label>
        <div class="col-lg-10">
            <textarea
                    name="description"
                    cols="30"
                    rows="10"
                    class="form-control">{{ old('description') ?
                    old('description') : ( $company && $company->description ? $company->description : '' ) }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="what_it_does" class="col-lg-2 control-label">What it does</label>
        <div class="col-lg-10">
            <textarea
                    name="what_it_does"
                    cols="30"
                    rows="10"
                    class="form-control">{{ old('what_it_does') ?
                    old('what_it_does') : ( $company && $company->what_it_does ? $company->what_it_does : '' ) }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="office_life" class="col-lg-2 control-label">Office Life</label>
        <div class="col-lg-10">
            <textarea
                    name="office_life"
                    cols="30"
                    rows="10"
                    class="form-control">{{ old('office_life') ?
                    old('office_life') : ( $company && $company->office_life ? $company->office_life : '' ) }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label for="office_life" class="col-lg-2 control-label">Country</label>
        <div class="col-lg-10">
            <select name="country_id" id="country_id" class="form-control">
                <option value="">Please select</option>
                @foreach($countries as $country)
                    <option
                            value="{{ $country->id }}"
                            {{ $company && $company->country_id == $country->id ? 'selected="selected"' : '' }}
                            {{ $company && !$company->country_id && $country->id == 222 ? 'selected="selected"' : '' }}
                            {{ old('country_id') && $country->id == old('country_id') ? 'selected="selected"' : '' }}
                    >
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="office_life" class="col-lg-2 control-label">State</label>
        <div class="col-lg-10">
            <select name="state_id" id="state_id" class="form-control">
                <option value="">Please select</option>
                @foreach($states as $state)
                    <option
                            value="{{ $state->id }}"
                            {{ $company && $company->state_id == $state->id ? 'selected="selected"' : '' }}
                            {{ old('state_id') && $state->id == old('state_id') ? 'selected="selected"' : '' }}
                    >
                        {{ $state->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="well">
        <div class="pull-left">
            <a
                    href="{{route('admin.access.users.index')}}"
                    class="btn btn-danger btn-xs">
                {{ trans('strings.cancel_button') }}
            </a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success btn-xs" value="{{ trans('strings.save_button') }}" />
        </div>
        <div class="clearfix"></div>
    </div><!--well-->

    </form>

    <div class="clearfix"></div>
@stop

@section('after-scripts-end')
    <script>
        $(document).ready(function(){
            $('#country_id').on('change', function(){
                $.getJSON('/admin/get-states/'+$(this).val(), function(json){
                    var listitems = '<option value="">Please select</option>';
                    $.each(json,function(key, value)
                    {
                        listitems += '<option value=' + value.id + '>' + value.name + '</option>';
                    });
                    $('#state_id').html(listitems);
                });
            });
        });
    </script>
@endsection
