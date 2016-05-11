@extends ('backend.layouts.master')

@section ('title', 'Jobseekers')

@section('page-header')
    <h1>
        Bloggers
        <small>Bloggers Dashboard</small>
    </h1>
@endsection

@section('content')



    <div class="col-md-6">
        <h4>Bloggers</h4>
    </div>


    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>E-Mail</th>
        </tr>
        </thead>
        <tbody>

        @foreach($bloggers as $user)

            <tr>


                    @if ($user->roles()->count() > 0)

                            <?php
                           foreach ($user->roles as $role):


                            if($role->name=='Blogger'):
                                    ?>
                            <td>{!! $user->id !!}</td>
                            <td>{!! $user->name !!}</td>
                            <td>{!! link_to("mailto:".$user->email, $user->email) !!}</td>
                          <?php
                                break;
                                endif;
                               endforeach;
                      ?>
                    @else
                        None
                    @endif



            </tr>



        @endforeach
        </tbody>
    </table>

    <div class="col-md-12 center-block">
        {!! $bloggers->render() !!}
    </div>

    <div class="clearfix"></div>

@stop


@section('after-scripts-end')
    <script>
        $(document).ready(function () {
            $('#country_id').on('change', function () {
                $.getJSON('/admin/get-states/' + $(this).val(), function (json) {
                    var listitems = '<option value="">Please select</option>';
                    $.each(json, function (key, value) {
                        listitems += '<option value=' + value.id + '>' + value.name + '</option>';
                    });
                    $('#state_id').html(listitems);
                });
            });
        });
    </script>
@endsection

