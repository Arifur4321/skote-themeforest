
@extends('layouts.master')
@section('title')
    @lang('translation.arifurtable')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Projects
        @endslot
        @slot('title')
            Contract List 
        @endslot
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <button type="button" class="btn btn-primary" onclick="redirectTocreatecontract()">Add New Contract</button>
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
</script>





<script>
    function redirectTocreatecontract() {
        // Redirect to the route associated with createcontract.blade.php
        window.location.href = "/createcontract"; // Replace with your actual route path
    }

    // function redirectToEditcontract(contractId, contractName, editorContent) {
    // // Redirect to the edit contract page with contract details in the URL
    // window.location.href = "/edit-contract-list?contractId=" + contractId + "&contractName=" + 
    // contractName + "&editorContent=" + encodeURIComponent(editorContent);
    // }

    function redirectToEditContract(contractId) {
    window.location.href = "/edit-contract-list/" + contractId;
    }



</script>




<!-- Table content -->
<table id="ContractList" class="table">
    <!-- Table header -->
    <thead>
        <tr>
            <th>Contract ID</th>
            <th>Contract Name</th>
            <th>User Name</th>
            <th>Created Date</th>
            <th>Updated Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <!-- Table body -->
    <tbody>
        @foreach($contracts as $contract)
        <tr>
            <td>{{ $contract->id }}</td>
            <td>{{ $contract->contract_name }}</td>
            <td>{{ $contract->logged_in_user_name }}</td>
            <td>{{ $contract->created_at }}</td>
            <td>{{ $contract->updated_at }}</td>
            <td>
                <!-- Dropdown menu for actions -->
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- Edit action -->
                        <a href="#" class="dropdown-item edit-list" onclick="redirectToEditContract('{{ $contract->id }}')">
                            <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit
                        </a>
                        <!-- History action -->
                        <a href="#" class="dropdown-item">
                            <i class="mdi mdi-history font-size-16 text-info me-1"></i> History
                        </a>
                        <!-- Delete action form -->
                        <form id="delete-form-{{ $contract->id }}" action="{{ route('contracts.destroy', $contract->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>

                        <!-- Delete link with confirmation -->
                        <a href="#" class="dropdown-item edit-list" onclick="confirmDelete('{{ $contract->id }}');">
                            <i class="mdi mdi-delete font-size-16 text-danger me-1"></i> Delete
                        </a>

                        <!-- JavaScript for confirmation popup -->
                        <script>
                            function confirmDelete(contractId) {
                                // Display confirmation popup
                                if (confirm('Are you sure you want to delete this contract?')) {
                                    // If user clicks 'Yes', submit the form
                                    document.getElementById('delete-form-' + contractId).submit();
                                } else {
                                    // If user clicks 'No', do nothing
                                    return false;
                                }
                            }
                        </script>


                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


 <!-- Add a form for selecting items per page -->
 <form action="{{ route('contracts.index') }}" method="GET" class="mb-3">
    <label for="perPage">Items per page:</label>
    <select name="perPage" id="perPage" onchange="this.form.submit()">
        <option value="5" {{ Request::input('perPage') == 5 ? 'selected' : '' }}>5</option>
        <option value="10" {{ Request::input('perPage') == 10 ? 'selected' : '' }}>10</option>
        <option value="20" {{ Request::input('perPage') == 20 ? 'selected' : '' }}>20</option>
        <!-- Add more options as needed -->
    </select>
</form>
<!-- Pagination links -->
<div class="d-flex justify-content-center">
    {{ $contracts->appends(request()->input())->links() }}
</div>


<style>
    .w-5{
        display:none;
    }
</style>




 <!-- edit Modal contract list -->
 <div   class="modal fade"  id="exampleModal" tabindex="-1" aria-labelledby="#exampleModalFullscreenLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editContractModalLabel{{ $contract->id }}">Edit Contract</h5>
                <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">&times;</span>-->
                </button>
                <div class="col-sm-auto">
                    <div class="text-sm-end">
                        <button type="button" class="btn btn-primary" onclick="openModalNew()">Variable</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="projectForm">
                    <input type="hidden" id="contract-id" name="project_id">   
                    <div class="mb-3">
                        <label for="project-name-new" class="col-form-label">Contract Name :</label>
                        <input type="text" class="form-control" id="project-name-new" value="{{ $contract-> contract_name }}">
                    </div>
                    <!-- CKEditor for editing contract content -->
                    <textarea id="editormodal" name="editormodal">{{ $contract->editor_content }}</textarea>
                </form> 
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveEditedContent( )">Save</button>
            </div>
        </div>
    </div>
</div>
 
 
 
 
<!-- variable Modal -->
<!-- product list Modal -->
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
                                
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($variables as $contract)
                                    <tr>
                                        <td>{{ $contract->VariableID }}</td>
                                        <td>{{ $contract->VariableName }}</td>
                                        <td>{{ $contract->VariableType }}</td>
                                    
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
 
  <style>
    #exampleModalNew .modal-content {
        background-color: black;
        color: white; /* Optionally, change the text color */
    }
</style>

@endsection
@section('script')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>


            let editormodal;  // Declare editormodal as a global variable

            document.addEventListener('DOMContentLoaded', function() {
            editormodal = document.getElementById('editormodal');

            if (editormodal) {
                ClassicEditor
                    .create(editormodal)
                    .then(editor => {
                        // Your initialization code here
                        editormodal = editor;

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
            } else {
                console.error('Textarea element with ID "editormodal" not found.');
            }
        });

        function openModal(id, name, contractContent) {
            // Using Bootstrap's JavaScript to open the modal
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            
            // Set values in the modal form
            document.getElementById('contract-id').value = id;
            document.getElementById('project-name-new').value = name;
            // Use setData to set content in CKEditor
            editormodal.setData(contractContent);
            
            // Show the modal
            myModal.show();
        }

        function saveEditedContent() {
            // Get the CKEditor instance and its data
            var editorData = editormodal.getData();
            
            // Get the contract name and ID
            const contractId = document.querySelector('#contract-id').value;
            const contractName = document.querySelector('#project-name-new').value;
            
            // Send the edited content to the server using AJAX
            saveContent(contractId, contractName, editorData);
            // Close the modal
            $('#exampleModal').modal('hide');
        }

        function saveContent(id, title, content) {
            $.ajax({
                url: '/updatecontract',
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    contract_name: title,
                    editor_content: content
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }


        // Function to save data when Save button is clicked
        function saveData() {
            const title = document.querySelector('#title').value; // Get title
            const content = editor.getData(); // Get content from CKEditor
            saveContent(title, content); // Call saveContent function to save data
        }

        function saveDatamodal() {
            const title = document.querySelector('#titlemodal').value; // Get title
            const content = editormodal.getData(); // Get content from CKEditor
           // saveContent(title, content); // Call saveContent function to save data
        }


        // for variable button  
        function openModalNew() {
        // Using Bootstrap's JavaScript to open the product list modal
        var myModal = new bootstrap.Modal(document.getElementById('exampleModalNew'));
        myModal.show();
        }
 

    $('#exampleModalNew').modal('hide');

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
                    var editorData = editormodal.getData();
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
