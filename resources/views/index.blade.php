<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Task</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="{{ asset('js') }}/sweetalert2@8.js"></script>
        <script src="{{ asset('js') }}/sweetalert.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    </head>

    <body>
        <div style="padding: 30px;"></div>
        <div class="container">
            <h2 style="color: red;">
            </h2>


            <div class="row">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header">
                            All Task
                        </div>


                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Task Name</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1 @endphp
                                    @foreach ($allDatas as $data)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->task_name }}</td>


                                        <td>
                                            <div class="btn-group">
                                                <a>
                                                    <button class="btn btn-md btn-success me-1 p-1" onclick='editData({{ $data->id }})'><i class="fas fa-edit"></i></button>
                                                </a>

                                                <form action="{{ route('delete') }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="hidden" name="data_id" value="{{ $data->id }}">
                                                    <button class="btn btn-md btn-danger p-1"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>



                        </div>

                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <span id="addT">Add New Task</span> <br>
                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif
                            <span id="output"></span>
                        </div>

                        <div class="card-body">
                            <form id="my-form">
                                @csrf

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Task Name</label>
                                    <input type="text" id="task_name" name="task_name" class="form-control" aria-describedby="emailHelp" placeholder="Task name" required>

                                </div>
                                <input type="hidden" id="id">
                                <br>
                                <button type="submit" id="btnSubmit" class="btn btn-primary">Save</button>
                                <button type="submit" id="updateBtn" class="btn btn-primary" onclick='updateData()'>Update</button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')
            }
        })
    </script>

<script>
   
        $('#btnSubmit').show();
     
        $('#updateBtn').hide();
    </script>

 <script>
        $(document).ready(function() {
            $("#my-form").on("submit", function(e) {
                e.preventDefault();
                var form = $("#my-form")[0];
                var data = new FormData(form);

                // Disable the submit button while the AJAX request is in progress
                $("#btnSubmit").prop("disabled", true);

                // Send the AJAX request
                $.ajax({
                    type: "POST",
                    url: "{{ route('store') }}", // Replace with your server-side endpoint
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(data) {

                        // Handle the response from the server
                        $("#output").text(data.message);
                        setTimeout(function() {
                            $("#output").text("");
                        }, 2000);

                        $("#btnSubmit").prop("disabled", false); // Re-enable the submit button
                        form.reset();
                        $('table').load(location.href + ' .table');
                    },
                    error: function(e) {
                        // Handle the error
                        $("#output").text(data.responseText);
                        $("#btnSubmit").prop("disabled", false); // Re-enable the submit button
                    }
                });
            });
        });
    </script>

<script>
        function editData(id) {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                url: "/edit/" + id, // Replace with your actual URL structure
                success: function(data) {
                    $('#addT').hide();
                    $('#btnSubmit').hide();
                    $('#updateT').show();
                    $('#updateBtn').show();

                    $('#id').val(data.id);

                    $('#task_name').val(data.task_name);
                   
                   
                }
            });
        }
    </script>

<script>
        function updateData(id) {
            var id = $('#id').val();
            var task_name = $('#task_name').val();
   
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {
                    task_name: task_name,
                 
                },
                url: "/update/" + id, // Replace with your actual URL structure

                success: function(data) {
               
                    $('#btnSubmit').show();
                    $('#updateBtn').hide();
                   
                }
            });
        }
    </script>

</x-app-layout>