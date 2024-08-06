<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token()}}">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <title>Dynamic Dependent Dropdown</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>

<body>
    <div class="bg p-3 text-white shadow-lg text-center">
        <h1>Laravel Dynamic Dependent Dropdown Tutorial</h1>
    </div>
    <div class="container mt-3">
        <div class="row d-flex justify-content-center">

            <div class="col-md-6">
                <div class="card card-primary p-4 border-0 shadow-lg">
                    <form action="" method="post" class="frm" name="frm" id="frm">
                      <a href="{{route('list')}}">Back </a> 
                        <div class="card-body">
                            <h3>Edit-user</h3>
                            <div class="mb-3">
                                <input type="text" value="{{$users->name }}" name="name" id="name" class="form-control" placeholder="Enter name">
                                <p class="invalid-feedback" id="name-error"></p>
                            </div>
                            <div class="mb-3">
                                <input type="text" value="{{$users->email }}" name="email" id="email" class="form-control" placeholder="Enter email">
                                <p class="invalid-feedback" id="email-error"></p>

                            </div>
                            <div class="mb-3">
                                <select name="country" id="country" class="form-control">
                                    <option value="">Select Country</option>
                                    @if(!empty($countries))
                                    @foreach($countries as $country )
                                    <option {{ ($users->country == $country->id) ?'selected':"" }} value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="state" id="state" class="form-control">
                                    <option value="">Select state</option>

                                    @if(!empty($states))
                                    @foreach($states as $state )
                                    <option{{ ($users->state == $state->id) ?'selected':"" }} value="{{$state->id}}">{{$state->name}}</option>
                                        @endforeach
                                        @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="cities" id="cities" class="form-control">
                                    <option value="">Select city</option>

                                    @if(!empty($cities))
                                    @foreach($cities as $city )
                                    <option {{ ($users->city == $city->id) ?'selected':"" }} value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $("#country").change(function() {
                var country_id = $(this).val();
                if (country_id == "") {
                    var country_id = 0;
                }
                $.ajax({

                    url: '{{url("/fetch_states/")}}/' + country_id,
                    type: 'post',
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);

                        $('#state').find('option:not(:first)').remove();
                        $('#cities').find('option:not(:first)').remove();
                        if (response['states'].length > 0) {
                            $.each(response['states'], function(key, value) {
                                $("#state").append("<option value='" + value['id'] + "'>" + value['name'] + "</option>")
                            });
                        }

                    }
                });

                // console.log(country_id);
            });

            $("#state").change(function() {
                var state_id = $(this).val();
                console.log(state_id);
                if (state_id == "") {
                    var state_id = 0;
                }
                $.ajax({

                    url: '{{url("/fetch_cities/")}}/' + state_id,
                    type: 'post',
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);

                        $('#cities').find('option:not(:first)').remove();

                        if (response['cities'].length > 0) {
                            $.each(response['cities'], function(key, value) {
                                $("#cities").append("<option value='" + value['id'] + "'>" + value['name'] + "</option>")
                            });
                        }

                    }
                });

                // console.log(country_id);
            });
        });

        $("#frm").submit(function(e) {
            e.preventDefault();

            $.ajax({

                url: '{{url("/update/".$users->id)}}',
                type: 'post',
                data: $("#frm").serializeArray(),
                dataType: 'json',

                success: function(response) {
                    if (response['status'] == 1) {
                        window.location.href = "{{url('list')}}";

                    } else {
                        if (response['errors']['name']) {
                            $("#name").addClass('is-invalid');
                            $("#name-error").html(response['errors']['name']);
                        } else {
                            $("#name").removeClass('is-invalid');
                            $("#name-error").html("");

                        }
                        if (response['errors']['email']) {
                            $("#email").addClass('is-invalid');
                            $("#email-error").html(response['errors']['email']);
                        } else {
                            $("#email").removeClass('is-invalid');
                            $("#email-error").html("");

                        }

                    }

                }
            });


        });
    </script>
</body>

</html>