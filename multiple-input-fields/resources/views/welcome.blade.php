<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>
<div class="container d-flex justify-content-center pt-5">
    <div class="col-md-9">
        <h2 class="text-center pb-3 text-danger">Form</h2>
        
        <form id="product-form">
            <div class="mb-3">
                <input type="text" id="search" class="form-control" placeholder="Search Names">
            </div>

            <table class="table table-bordered" id="table">
                <tr>
                    <th>Product Name</th>
                    <th>Length (cm)</th>
                    <th>Width (cm)</th>
                    <th>Color</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td><input type="text" name="inputs[0][name]" placeholder="Name" class="form-control" required></td>
                    <td><input type="number" name="inputs[0][length]" placeholder="Length" class="form-control" required></td>
                    <td><input type="number" name="inputs[0][width]" placeholder="Width" class="form-control" required></td>
                    <td>
                        <select name="inputs[0][color]" class="form-control" required>
                            <option value="">Select Color</option>
                            <option value="red">Red</option>
                            <option value="blue">Blue</option>
                            <option value="green">Green</option>
                            <option value="yellow">Yellow</option>
                        </select>
                    </td>
                    <td><button type="button" class="btn btn-danger remove-table-row">Remove</button></td>
                </tr>
            </table>
            
            <button type="button" id="add" class="btn btn-secondary mb-3">Add Product</button>
            <button type="submit" class="btn btn-primary col-md-2">Save</button>
        </form>
        
        <ul id="saved-data" class="list-group mt-3"></ul>
    </div>
</div>

<script>
    var i = 0;

    // Add new row
    $('#add').click(function() {
        ++i;
        $('#table').append(
            '<tr>' + 
                '<td>' + 
                    '<input type="text" name="inputs[' + i + '][name]" placeholder="Name" class="form-control" required/>' + 
                '</td>' + 
                '<td>' + 
                    '<input type="number" name="inputs[' + i + '][length]" placeholder="Length" class="form-control" required/>' + 
                '</td>' + 
                '<td>' + 
                    '<input type="number" name="inputs[' + i + '][width]" placeholder="Width" class="form-control" required/>' + 
                '</td>' + 
                '<td>' + 
                    '<select name="inputs[' + i + '][color]" class="form-control" required>' + 
                        '<option value="">Select Color</option>' + 
                        '<option value="red">Red</option>' + 
                        '<option value="blue">Blue</option>' + 
                        '<option value="green">Green</option>' + 
                        '<option value="yellow">Yellow</option>' + 
                    '</select>' + 
                '</td>' + 
                '<td>' + 
                    '<button type="button" class="btn btn-danger remove-table-row">Remove</button>' + 
                '</td>' + 
            '</tr>'
        );
    });

    // Remove row
    $(document).on('click', '.remove-table-row', function() {
        $(this).closest('tr').remove();
    });

    // Search functionality
    $('#search').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#saved-data li').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Handle form submission
    $('#product-form').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        // Collect input values
        var inputs = $(this).find('input[name^="inputs"], select[name^="inputs"]');
        var productData = [];

        // Loop through the inputs and collect data
        inputs.each(function() {
            var name = $(this).val();
            var nameAttr = $(this).attr('name');
            var index = nameAttr.match(/\d+/)[0]; // Extract index from name attribute

            // Initialize the product object if it doesn't exist
            if (!productData[index]) {
                productData[index] = {
                    name: '',
                    length: '',
                    width: '',
                    color: ''
                };
            }

            // Assign the value to the correct property
            if (nameAttr.includes('name')) {
                productData[index].name = name;
            } else if (nameAttr.includes('length')) {
                productData[index].length = name;
            } else if (nameAttr.includes('width')) {
                productData[index].width = name;
            } else if (nameAttr.includes('color')) {
                productData[index].color = name;
            }
        });

        // Append the collected data to the saved-data list
        $.each(productData, function(index, data) {
            if (data.name) { // Only add if the name is not empty
                $('#saved-data').append('<li class="list-group-item">' + 
                    'Name: ' + data.name + ', Length: ' + data.length + ' cm, Width: ' + data.width + ' cm, Color: ' + data.color + 
                    ' <button class="btn btn-warning btn-sm float-end edit-saved">Edit</button>' + 
                    ' <button class="btn btn-danger btn-sm float-end remove-saved">Delete</button>' + 
                '</li>');
            }
        });

        // Clear input fields after saving
        $(this).find('input[type="text"], input[type="number"], select').val('');
    });

    // Delete saved data
    $(document).on('click', '.remove-saved', function() {
        $(this).closest('li').remove();
    });

    // Edit saved data
    $(document).on('click', '.edit-saved', function() {
        var listItem = $(this).closest('li');
        var currentText = listItem.text().replace('EditDelete', '').trim().split(', ');

        // Create input fields for editing
        var inputFields = '<input type="text" class="form-control" value="' + currentText[0].split(': ')[1] + '"/>' +
                          '<input type="number" class="form-control" value="' + currentText[1].split(': ')[1] + '"/>' +
                          '<input type="number" class="form-control" value="' + currentText[2].split(': ')[1] + '"/>' +
                          '<select class="form-control"><option value="' + currentText[3].split(': ')[1] + '">' + currentText[3].split(': ')[1] + '</option>' +
                          '<option value="red">Red</option><option value="blue">Blue</option><option value="green">Green</option><option value="yellow">Yellow</option></select>';

        listItem.html(inputFields + 
            ' <button class="btn btn-success btn-sm float-end save-saved">Save</button>' + 
            ' <button class="btn btn-danger btn-sm float-end remove-saved">Delete</button>');
    });

    // Save edited data
    $(document).on('click', '.save-saved', function() {
        var listItem = $(this).closest('li');
        var inputs = listItem.find('input, select');
        var newData = 'Name: ' + inputs.eq(0).val() + ', Length: ' + inputs.eq(1).val() + ' cm, Width: ' + inputs.eq(2).val() + ' cm, Color: ' + inputs.eq(3).val();

        listItem.html(newData + 
            ' <button class="btn btn-warning btn-sm float-end edit-saved">Edit</button>' + 
            ' <button class="btn btn-danger btn-sm float-end remove-saved">Delete</button>');
    });
</script>
</body>
</html>