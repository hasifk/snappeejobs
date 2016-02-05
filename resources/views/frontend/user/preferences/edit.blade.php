@extends('frontend.layouts.master')

@section('content')
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">Update your preferences</div>

                <div class="panel-body">

                    <h3>Update Preferences</h3>

                    <form method="post" action="" class="form-horizontal">

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
                                            <option value="{{ $job_category->id }}">
                                                {{ $job_category->name }}
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
                                            value="small" {{ request('size') == 'small' ? 'checked="checked"' : '' }}
                                    />
                                    <label for="size_small">Small</label>
                                    &nbsp;
                                    <input
                                            type="radio"
                                            name="size"
                                            id="size_medium"
                                            v-model="size"
                                            value="medium" {{ request('size') == 'medium' ? 'checked="checked"' : '' }}
                                    />
                                    <label for="size_medium">Medium</label>
                                    &nbsp;
                                    <input
                                            type="radio"
                                            name="size"
                                            id="size_big"
                                            v-model="size"
                                            value="big" {{ request('size') == 'big' ? 'checked="checked"' : '' }}
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

                </div><!--panel body-->

            </div><!-- panel -->

        </div><!-- col-md-10 -->

    </div><!-- row -->
@endsection

@section('after-scripts-end')
    <script>

    </script>
@endsection
