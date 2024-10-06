<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shorten your URL</title>
    <style>
        #url_label{
            padding: 10px;
        }
        #input_url{
            width: 80%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: whitesmoke;
            color: black;
            
        }
        #ur_submit_button{
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #ur_submit_button:hover{   
            background-color: #2c702f;
        }
        .card{
            display: none;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container">
        <h1>Shorten your URL</h1>
        <br>
        <div class="row">
            <label id="url_label" for="input_url"> URL </label>
            <input type="url" id="input_url" name="input_url" placeholder="Enter a URL" required>
            <button id="ur_submit_button" type="submit">Submit URL</button>
        </div>
        <div class="card" id="result">
            <h2>Shortened URL:</h2>
            <p id="shortened_url"></p>
        </div>
    </div> 
</body>
    <script>
        $(document).ready(function() {

            $('#ur_submit_button').on('click', function(event) {
                event.preventDefault();

                let url = $('#input_url').val();

                if (!url) {
                    alert('Please enter a URL.');
                    return;
                }

                $.ajax({
                    url: "{{ route('shorten-url') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { 
                        url: url
                    },
                    success: function(response) {
                        if (response) {
                            $('#shortened_url').html('<a href="' + response.data.shortened_url + '" target="_blank">' + response.data.shortened_url + '</a>');
                            $('#result').fadeIn();
                        } else {
                            alert('something went wrong');
                        }
                    },
                    error: function(response, status, error) {
                        console.error('Error:', error);
                        alert(response.responseJSON.message);
                    }
                });
            });
        });
    </script>
</html>