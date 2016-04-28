@extends('frontend.layouts.masternew')

@section('content')

    <div class="bodycontent">

        <div class="container cnt-body">

            <div class="row">

                <h3 class="text-center">Update Preferences</h3>

                <form method="post" action="" class="form-horizontal">

                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="description" class="col-lg-4 control-label">Skills</label>
                        <div class="col-lg-6">
                            <select
                                    v-model="skills"
                                    name="skills[]"
                                    id="skills"
                                    class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                    multiple="multiple"
                                    style="width: 100%;"
                            >
                                @if (count($skills) > 0)
                                    @foreach($skills as $skill)
                                        <option
                                                value="{{ $skill->id }}"
                                                {{ old('skills')
                                                && in_array($skill->id, old('skills')) ? 'checked="checked"' : '' }}
                                                {{ !old('skills') && ( $job_seeker && $job_seeker->skills)
                                                    && in_array($skill->id, array_pluck($job_seeker->skills->toArray(), 'id')) ? 'selected="selected"' : '' }}
                                        >
                                            {{ $skill->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-lg-4 control-label">Preffered Job Categories</label>
                        <div class="col-lg-6">
                            <select
                                    v-model="job_categories"
                                    name="job_categories[]"
                                    id="job_categories"
                                    class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                    multiple="multiple"
                                    style="width: 100%;"
                            >
                                @if (count($job_categories) > 0)
                                    @foreach($job_categories as $job_category)
                                        <option
                                                value="{{ $job_category->id }}"
                                                {{ old('job_categories')
                                                && in_array($job_category->id, old('job_categories')) ? 'checked="checked"' : '' }}
                                                {{ !old('job_categories') && ( $job_seeker && $job_seeker->categories)
                                                    && in_array($job_category->id, array_pluck($job_seeker->categories->toArray(), 'id')) ? 'selected="selected"' : '' }}
                                        >
                                            {{ $job_category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-lg-4 control-label">Preffered Industries</label>
                        <div class="col-lg-6">
                            <select
                                    v-model="industries"
                                    name="industries[]"
                                    id="industry_preferences"
                                    class="form-control select2 select2-hidden-accessible js-example-basic-multiple"
                                    multiple="multiple"
                                    style="width: 100%;"
                            >
                                @if (count($industries) > 0)
                                    @foreach($industries as $industry)
                                        <option
                                                value="{{ $industry->id }}"
                                                {{ old('industries')
                                                && in_array($industry->id, old('industries')) ? 'checked="checked"' : '' }}
                                                {{ !old('industries') && ( $job_seeker && $job_seeker->industries)
                                                    && in_array($industry->id, array_pluck($job_seeker->industries->toArray(), 'id')) ? 'selected="selected"' : '' }}
                                        >
                                            {{ $industry->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-lg-4 control-label">I prefer working in a company which is</label>
                        <div class="col-lg-6">
                            <div class="checkbox">
                                <input
                                        type="radio"
                                        name="size"
                                        id="size_small"
                                        v-model="size"
                                        value="small"
                                        {{
                                            old('size') ? old('size') == 'small' ? 'checked="checked"' : '' :
                                            $job_seeker && $job_seeker->size == 'small' ? 'checked="checked"' : ''
                                        }}
                                />
                                <label for="size_small">Small</label>
                                &nbsp;
                                <input
                                        type="radio"
                                        name="size"
                                        id="size_medium"
                                        v-model="size"
                                        value="medium"
                                        {{
                                            old('size') ? old('size') == 'medium' ? 'checked="checked"' : '' :
                                            $job_seeker && $job_seeker->size == 'medium' ? 'checked="checked"' : ''
                                        }}
                                />
                                <label for="size_medium">Medium</label>
                                &nbsp;
                                <input
                                        type="radio"
                                        name="size"
                                        id="size_big"
                                        v-model="size"
                                        value="big"
                                        {{
                                            old('size') ? old('size') == 'big' ? 'checked="checked"' : '' :
                                            $job_seeker && $job_seeker->size == 'big' ? 'checked="checked"' : ''
                                        }}
                                />
                                <label for="size_big">Big</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button class="btn btn-primary" type="submit" value="Update">Update</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

