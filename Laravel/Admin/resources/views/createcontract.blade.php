@extends('layouts.master')

@section('title') @lang('translation.createcontract') @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Forms @endslot
        @slot('title') Codice 1% Form Editors @endslot
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Add this line in your HTML file before your own JavaScript code -->



    <div class="row justify-content-end">
        <!-- First button 
        <div class="col-auto">
            <div class="text-end">
                <button type="button" class="btn btn-primary"  onclick="openModalNew()">Create New Contract</button>
            </div>
        </div> -->


<!-- variable Modal -->
<div class="modal" id="exampleModalNew" tabindex="-1" aria-labelledby="exampleModalLabelNew" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelNew">Variable List</h5>
                <div class="col-sm">
                    <div class="search-box me-2 d-inline-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" autocomplete="off" id="searchInput" placeholder="Search...">
                            <i class="bx bx-search-alt search-icon"></i>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productFormNew" action="/createcontract" method="POST" >
                    <!-- for table -->
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <!-- Wrap the table inside a div with fixed height and auto scroll -->
                    <div style="max-height: 400px; overflow-y: auto;">
                        <table id="ContractList" action="/createcontract" method="POST" class="table">
                            <thead>
                                <tr>
                                    <th>VariableID</th>
                                    <th>Var Name</th>
                                    <th>Var Type</th>
                                    <th>Description</th>
                                    <th>CreatedDate</th>
                                    <th>UpdatedDate</th>
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
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input add-checkbox"
                                                 onchange="checkCheckbox(this, '{{ $contract->VariableName }}') ">
                                            </label>
                                            <button type="button" class="btn btn-primary add-button"
                                             data-bs-dismiss="modal" onclick="insertVariable('{{ $contract->VariableName }}')" disabled> Add </button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary" onclick="">Save Product</button> -->
            </div>
        </div>
    </div>
</div>
 


    
    <!-- Product Modal -->
    <div class="modal" id="exampleModalProduct" tabindex="-1" aria-labelledby="exampleModalLabelNew" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelNew">Product List</h5>
                    <div class="col-sm">
                        <div class="search-box me-2 d-inline-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" autocomplete="off" id="searchInputproduct" placeholder="Search...">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    <form id="productFormNew" action="/createcontract" method="POST">
                        <!-- for table -->
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <table id="ProductList" action="/createcontract" method="POST" class="table">
                            <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        <!-- Checkbox to select product -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $product->id }}" id="productCheckbox_{{ $product->id }}" name="selectedProduct">
                                            <label class="form-check-label" for="productCheckbox_{{ $product->id }}">
                                                Add
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary" onclick="">Save Product</button> -->
                </div>
            </div>
        </div>
    </div>

<script>
 document.addEventListener("DOMContentLoaded", function() {
    // Get all checkboxes within the modal content
    var checkboxes = document.querySelectorAll('#exampleModalProduct input[type="checkbox"]');
    
    // Add event listener to each checkbox
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Uncheck all checkboxes except the one that was just checked
            checkboxes.forEach(function(cb) {
                if (cb !== checkbox) {
                    cb.checked = false;
                }
            });
        });
    });
});
</script>

 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 

<script>
         

    $(document).ready(function() {
        // Delegate the change event handling to the tbody element
        $('tbody').on('change', '.add-checkbox', function() {
            // Find the parent row of the checkbox
            var $row = $(this).closest('tr');
            // Find the add button within the same row and enable/disable it based on the checkbox state
            $row.find('.add-button').prop('disabled', !$(this).prop('checked'));
        });
    });
</script>


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

    $(document).ready(function () {
        // Reference to the input field and the table
        var $searchInput = $('#searchInputproduct');
        var $table = $('#ProductList');

        // Event listener for keyup on the search input
        $searchInput.on('keyup', function () {
            var searchText = $(this).val().toLowerCase();

            // Filter the table rows based on the search text
            $table.find('tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1);
            });
        });
    });
  
</script>

<div class="card">
    <div class="card-body">
        <form id="contractForm" action="/createcontract" method="POST">
         
        <div class="d-flex align-items-center mb-3">
            <label for="title" class="form-label me-2" style="width: 120px;">Contract Name</label>
            <input type="text" class="form-control w-75" id="title" name="title">
            
            <div class="ms-2 d-flex">
                <button type="button" class="btn btn-primary me-2 btn-lg" onclick="openproductmodal()">Product</button>
                <!-- open modal to show all table 

                <button type="button" class="btn btn-primary me-2 btn-lg" onclick="saveData('variable')">Variable</button> -->

                <button type="button" class="btn btn-primary me-2 btn-lg"  onclick="openModalNew()">Variable</button>
                

             
                <!-- Button to insert dummy  text 
                <button id="insertTextBtn"  >Insert Text</button> -->

                 
          
                <!-- Include the CKEditor library -->
       
            </div>
            
            <div class="ms-2">
                <button type="button" class="btn btn-primary me-2 btn-lg" onclick="saveData('save')">Save</button>
            </div>
        </div>
       
            
           

            <!-- arifur CSKEdiotr  -->
             <textarea id="editor" name="editor" style="width: 100%; max-width: 500px;"></textarea>

            <style>
                .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
                    border-color: var(--ck-color-base-border);
                    height: 400px !important;
                
                }
                .ck.ck-editor__editable_inline>:last-child {
                    margin-bottom: var(--ck-spacing-large);
                    height: 400px;
                }

            </style>
        </form>
 

    </div>
</div>


<script>
function fetchVariables() {
    $.ajax({
        url: '/fetch-variables',
        type: 'GET',
        success: function (response) {
            populateModal(response);
        },
        error: function (error) {
            console.error('Error fetching data:', error);
        }
    });
}

    function populateModal(data) {
        // Populate your modal with the fetched data
        // For example, you can loop through the data and create table rows
        // Then display the modal
    }
    function openproductmodal() {
            // Using Bootstrap's JavaScript to open the product list modal
            var myModal = new bootstrap.Modal(document.getElementById('exampleModalProduct'));
            myModal.show();
        }
    $('#exampleModalProduct').modal('hide');

    function openModalNew() {
            // Using Bootstrap's JavaScript to open the product list modal
            var myModal = new bootstrap.Modal(document.getElementById('exampleModalNew'));
            myModal.show();
        }

    $('#exampleModalNew').modal('hide');
</script>

@endsection

@section('script')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
        let editor; // Global variable for main CKEditor instance        
        
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(createdEditor => {
                // Assign the created editor to the global variable
                editor = createdEditor;

                // Define a function to insert text into CKEditor 5
                window.insertVariable = function(variableName) {
                    // Insert variableName at the current cursor position
                    const currentPosition = editor.model.document.selection.getLastPosition();
                    if (currentPosition) {
                        editor.model.change(writer => {
                            writer.insertText("%"+variableName+"%", currentPosition);
                        });
                    }
                }
            })
            .catch(error => {
                console.error(error);
            });
                
        // Function to save data when Save button is clicked
        function saveData() {
            // Check if CKEditor is initialized
            if (!editor) {
                console.error('CKEditor is not initialized.');
                return;
            }

            // Get the contract name from the input field
            const contractName = document.querySelector('#title').value;

            // Check if the contract name is empty

            if (!contractName.trim()) {
                console.error('Contract name cannot be empty.');
                return;
            }

            // Get all form fields
            const formData = {
                _token: "{{ csrf_token() }}",
                contract_name: contractName, // Ensure contract_name is included
                editor_content: editor.getData(), // Get data from CKEditor
            };

            saveContent(formData); // Call saveContent function to save data
        }
        function saveContent(formData) {
            $.ajax({
                url: '/savecontract',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
         
        

        //Function to insert a variable into CKEditor
        function insertVariable(variableName) {
            // Get the current content of the editor
            const currentContent = editor.getData();
            // Append the variable to the content with % signs
            const newContent = currentContent + `%${variableName}%`;
            // Set the updated content back to the editor
            editor.setData(newContent);
        }
 
        function countOccurrences(str, searchValue) {
        var regex = new RegExp(searchValue, 'g');
        var matches = str.match(regex);
        return matches ? matches.length : 0;
        }

        // Function to delete a substring from a string
        function deleteSubstring(str, searchValue) {
            var regex = new RegExp(searchValue, 'g');
            return str.replace(regex, '');
        }

        // Function to handle checkbox change event
        // Function to handle checkbox change event
            function checkCheckbox(checkbox, variableName) {
                if (!checkbox.checked) {
                    var editorData = editor.getData();
                    var count = countOccurrences(editorData, variableName);

                    if (count > 0) {
                        Swal.fire({
                            title: 'Variable Found!',
                            text: 'The variable ' + variableName + ' appears ' + count + ' times in the editor content. Do you want to delete it?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it',
                            cancelButtonText: 'No, cancel',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Perform delete operation
                                var latestvar = "%"+ variableName + "%"
                                editorData = deleteSubstring(editorData, latestvar);
                                editor.setData(editorData);
                            } else {
                                // If user cancels deletion, recheck the checkbox
                                checkbox.checked = true;
                            }
                        });
                    }
                }
            }
       
 
</script>
@endsection

