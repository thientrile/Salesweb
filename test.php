<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<form id="myForm">
    <input type="text" name="name" placeholder="Name">
    <input type="email" name="email" placeholder="Email">
    <button type="submit">Submit</button>
</form>
<div id="myData"></div>
<button id="getDataButton">Get Data</button>
<script>
    $(document).ready(function() {
        $('#myForm').submit(function(event) {
            event.preventDefault(); // prevent the form from submitting normally

            // get the form data



            var formData = new FormData(this);



            $.ajax({
                url: 'submit.php?name=hi',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res,req) {
                    // handle the response from the PHP script
                    console.log(res);
                },
                error: function(xhr, status, error) {
                    // handle errors
                    console.log(error);
                }
            });
        });
        $('#getDataButton').click(function() {
            $.ajax({
                url: 'http://demo.local/get.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let result = "";
                    for (let i of data) {

                        result += i.name;
                    }
                    $('#myData').html(result);

                },
                error: function(xhr, status, error) {
                    // handle errors
                    console.log(error);
                }
            });
        }); // update every 5 seconds
    });
</script>