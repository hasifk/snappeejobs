@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-home"></i> {{ trans('labels.employers') }}</div>

                <div class="panel-body">

					<form enctype="multipart/form-data" accept-charset="UTF-8" action="/employers" method="POST" role="form">

						{{ csrf_field() }}

						<div class="form-group">
							<label for="">Name</label>
							<input type="text" class="form-control" name="name" placeholder="Name">
						</div>

						<div class="form-group">
							<label for="">Email</label>
							<input type="text" class="form-control" name="email" placeholder="Email">
						</div>

						<div class="form-group">
							<label for="">Company</label>
							<input type="text" class="form-control" name="company" placeholder="Company">
						</div>

						<div class="form-group">
							<label for="">Country</label>
							<select name="country_id" id="country_id" class="form-control">
								<option value="">Please select</option>
								@foreach($countries as $country)
									<option value="{{ $country->id }}">
										{{ $country->name }}
									</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label for="">State</label>
							<select name="state_id" id="state_id" class="form-control">
								<option value="">Please select</option>
								@foreach($states as $state)
									<option value="{{ $state->id }}">
										{{ $state->name }}
									</option>
								@endforeach
							</select>
						</div>

						<button type="submit" class="btn btn-primary">Start Hiring</button>

					</form>

                </div>
            </div><!-- panel -->

		</div><!-- col-md-10 -->

	</div><!-- row -->
@endsection

@section('after-scripts-end')
    <script>
        $(document).ready(function(){
            $('#country_id').on('change', function(){
                $.getJSON('/get-states/'+$(this).val(), function(json){
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