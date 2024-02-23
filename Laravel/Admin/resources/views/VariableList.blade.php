@extends('layouts.master')
@section('title')
    @lang('translation.Variable-List')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Projects
        @endslot
        @slot('title')
        Variable List 
        @endslot
    @endcomponent


    <meta name="csrf-token" content="{{ csrf_token() }}">
     <!--  Arifur change  -->
     <div class="row">
    <div class="col-sm">
        <div class="search-box me-2 d-inline-block">
            <div class="position-relative">
                <input type="text" class="form-control" autocomplete="off" id="searchInput" placeholder="Search...">
                <i class="bx bx-search-alt search-icon"></i>
            </div>
        </div>
    </div>

    <div class="col-sm-auto">
        <div class="text-sm-end">
            <button type="button" class="btn btn-primary" onclick="openModalNew()">Add New Variable</button>
        </div>
    </div>
</div>


<!-- product list Modal -->
<div class="modal" id="exampleModalNew" tabindex="-1" aria-labelledby="exampleModalLabelNew" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelNew">New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productFormNew">
              
                    <div class="mb-3">
                        <label for="product-name-new" class="col-form-label">Variable Name:</label>
                        <input type="text" class="form-control" id="product-name-new">
                    </div>
                 
                    <div class="mb-3">
                        <label for="variable-type" class="col-form-label">Variable Type:</label>
                        <select class="form-select" id="variable-type">
                            <option value="Test 1">Test 1</option>
                            <option value="Test 2">Test 2</option>
                            <option value="Test 3">Test 3</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description-new" class="col-form-label">Description:</label>
                        <textarea class="form-control" id="description-new"></textarea>
                    </div>
               
                     
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveVariable()">Save Product</button>

            </div>
        </div>
    </div>
</div>


<script>
 function saveVariable() {
    var productName = $('#product-name-new').val();
    var description = $('#description-new').val();
    var variableType = $('#variable-type').val(); // Get the selected variable type

    if (!productName || !description || !variableType) {
        console.error('All fields must be filled out.');
        return;
    }

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/save-variable',
        type: 'POST',
        data: {
            VariableName: productName,
            description: description,
            variableType: variableType, // Use variable_type instead of variableType
            _token: csrfToken
        },
        success: function (response) {
            console.log('Data saved successfully.');
            $('#exampleModalNew').modal('hide');
        },
        error: function (error) {
            console.error('Error saving data:', error);
        }
    });
}


</script>



 
 



    <!-- for table -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <table id="ContractList" class="table">
    <thead>
        <tr>
            <th>VariableID</th>
            <th>Variable Name</th>
            <th>Variable Type</th>
            <th>Description</th>
            <th>Created Date</th>
            <th>Updated Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($variables as $contract)
            <tr>
                <td>{{ $contract->VariableID }}</td>
                <td>{{ $contract->VariableName }}</td>
                <td>{{ $contract->VariableType }}</td>
                <td>{{ $contract->Description }}</td>
                <td>{{ $contract->created_at }}</td>
                <td>{{ $contract->updated_at }}</td>
                <td>
    <div class="dropdown">
        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="mdi mdi-dots-horizontal font-size-18"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <ul class="dropdown-menu dropdown-menu-end show" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-31px, 27px, 0px);" data-popper-placement="bottom-end">
                <!-- Edit Button -->
                <li>
                   
                <a href="#" class="dropdown-item edit-list" onclick="openModal('{{ $contract->VariableID }}', '{{ $contract->VariableName }}', '{{ $contract->VariableType }}', '{{ $contract->Description }}')">
                    <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit
                </a>

                </li>
                <!-- History Button 
                <li>
                    <a href="" class="dropdown-item">
                        <i class="mdi mdi-history font-size-16 text-info me-1"></i> History
                    </a>
                </li>-->
                <!-- Delete Button -->
                <li>
                    <form action="" method="POST">
                      
                        <button type="submit" class="dropdown-item remove-list">
                            <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</td>

        </tr>
 
        @endforeach
    </tbody>
</table>


 
<!-- edit Modal -->
<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Variable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="variableForm">
                    <input type="hidden" id="variable-id" name="variable_id">
                    <div class="mb-3">
                        <label for="variable-name" class="col-form-label">Variable name:</label>
                        <input type="text" class="form-control" id="variable-name" name="variableName">
                    </div>
                    <div class="mb-3">
                        <label for="variable-type" class="col-form-label">Variable type:</label>
                        <select class="form-select" id="variable-type" name="variableType">
                            <option value="test1">Test 1</option>
                            <option value="test2">Test 2</option>
                            <option value="test3">Test 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="col-form-label">Description:</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="editVariable()">Save Variable</button>
            </div>
        </div>
    </div>
</div>


<!-- arifur for search -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

    $(document).ready(function () {
        // Reference to the input field and the table
        var $searchInput = $('#searchInput');
        var $table = $('#ContractList');

        // Event listener for keyup on the search input
        $searchInput.on('keyup', function () {
            var searchText = $(this).val().toLowerCase();

            // Filter the table rows based on the search text
            $table.find('tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
        });
    });

    function openModalNew() {
        // Using Bootstrap's JavaScript to open the product list modal
        var myModal = new bootstrap.Modal(document.getElementById('exampleModalNew'));
        myModal.show();
    }

 
        function editVariable() {
        var VariableID = document.getElementById('variable-id').value;
        var VariableName = document.getElementById('variable-name').value;
        var VariableType = document.getElementById('variable-type').value;
        var Description = document.getElementById('description').value;

        // AJAX request to update the variable
        $.ajax({
            url: '/update-variable/' + VariableID,
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}', // Add CSRF token for Laravel
                'VariableName': VariableName,
                'VariableType': VariableType,
                'Description': Description
            },
            success: function (data) {
                // Handle success, for example, close the modal
                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                myModal.hide();
                // You can perform additional actions here if needed
            },
            error: function (error) {
                // Handle error
                console.error('Error updating variable:', error);
            }
        });

        $('#exampleModal').modal('hide');
    }



    function openModal(variableID, variableName, variableType, description) {
    // Using Bootstrap's JavaScript to open the modal
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
    myModal.show();

    // Set values in the modal form
    document.getElementById('variable-id').value = variableID;
    document.getElementById('variable-name').value = variableName;
    document.getElementById('variable-type').value = variableType;
    document.getElementById('description').value = description;
}


</script>

@endsection