@extends('layouts.master')
@section('title')
    @lang('translation.HeaderAndFooter')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Projects
        @endslot
        @slot('title')
        Header And Footer Entries
        @endslot
    @endcomponent

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> 
    <link ref="stylesheet" href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css">   </link>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"  ></script>



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
            <button type="button" class="btn btn-primary" onclick="openModalNew()">Add New HeaderOrFooter</button>
        </div>
    </div>
</div>


                    <style>
                        

                        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
                            border-color: var(--ck-color-base-border);
                            height: 100px !important;
                        
                        }
                        .ck.ck-editor__editable_inline>:last-child {
                            margin-bottom: var(--ck-spacing-large);
                            height: 100px;
                        }

                        </style>
 
<div class="modal" id="exampleModalNew" tabindex="-1" aria-labelledby="exampleModalLabelNew" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelNew">New Header/Footer Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="headerFooterFormNew" novalidate>
                    <div class="mb-3">
                        <label for="entry-name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="entry-name" required>
                        <div class="invalid-feedback">
                            Please provide a name for the entry.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="entry-type" class="col-form-label">Type:</label>
                        <select class="form-select" id="entry-type" required>
                            <option value="Header">Header</option>
                            <option value="Footer">Footer</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a type for the entry.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="entry-editor-content" class="col-form-label">Editor Content:</label>
                        <textarea  class="form-control" id="entry-editor-content" required></textarea>
                        <div class="invalid-feedback">
                            Please provide content for the entry.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveHeaderFooter()">Save Entry</button>
            </div>
        </div>
    </div>
</div>



    <!-- Edit Modal -->
    <<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Header/Footer Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="entryForm">
                        <input type="hidden" id="entry-id-edit" name="entry_id-edit">
                        <div class="mb-3">
                            <label for="entry-name-edit" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="entry-name-edit" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="entry-type-edit" class="col-form-label">Type:</label>
                            <select class="form-select" id="entry-type-edit" name="type">
                                <option value="Header">Header</option>
                                <option value="Footer">Footer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="entry-editor-content-edit" class="col-form-label">Editor Content:</label>
                            <textarea class="form-control" id="entry-editor-content-edit" name="entry-editor-content-edit" rows="3">

                            
                            </textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editEntry()">Save Entry</button>
                </div>
            </div>
        </div>
    </div>

 
    <!-- for table -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <table id="HeaderAndFooterList" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <!-- <th>Content</th> -->
                <th>Created Date</th>
                <th>Updated Date</th>
                <th>Action</th>
            </tr>
        </thead>
       
        <tbody>
           @foreach($headerAndFooterEntries as $entry)
                <tr>
                    <td>{{ $entry->id }}</td>
                    <td>{{ $entry->name }}</td>
                    <td>{{ $entry->type }}</td>
                    <!-- <td>{{ $entry->editor_content }}</td> -->
                    <td>{{ $entry->created_at }}</td>
                    <td>{{ $entry->updated_at }}</td>
                    <td>
    <div class="dropdown">
        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="mdi mdi-dots-horizontal font-size-18"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <ul class="dropdown-menu dropdown-menu-end show" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-31px, 27px, 0px);" data-popper-placement="bottom-end">
                <!-- Edit Button -->
                
                   
                <a href="#" class="dropdown-item edit-list" onclick="openModal('{{ $entry->id }}', '{{ $entry->name }}', '{{ $entry->type }}', '{{ $entry->editor_content }}')">
                    <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit
                </a>
 
                <form id="deleteForm-{{ $entry->id }}" action="{{ route('entry.delete',$entry->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <a href="#" class="dropdown-item edit-list" onclick="confirmDelete('{{$entry->id}}');">
                        <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete
                    </a>
                    <!-- JavaScript for confirmation popup -->
                    <script>
                        function confirmDelete(contractId) {
                            // Display confirmation popup
                            if (confirm('Are you sure you want to delete this contract?')) {
                                // If user clicks 'Yes', submit the form
                                document.getElementById('deleteForm-' + contractId).submit();
                            } else {
                                // If user clicks 'No', do nothing
                                return false;
                            }
                        }
                    </script>
                </form>

              



            </ul>
        </div>
    </div>
</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    
<!-- For pagination  -->
<script>
//    let table = new DataTable('#ContractList');
$(document).ready(function() {
        let table = new DataTable('#HeaderAndFooterList');

        let lengthMenu = $('.dt-length');
        lengthMenu.appendTo($('#HeaderAndFooterList').parent().parent().parent().parent().parent().find('tfoot'));

       // let lengthMenu = $('.dt-length');
       // lengthMenu.addClass('smaller-length-menu').appendTo($('#ContractList').parent().parent().parent().parent().parent().find('tfoot'));

        // Hide additional search box
        $('.dt-search').hide();
        $('.dt-info').addClass('right-info');


        // Bind DataTable search to custom search box
        $('#searchInput').on('keyup', function() {
            table.search($(this).val()).draw();
        });
    });
 </script>

 





<!-- arifur for search -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    let editor; // Global variable for main CKEditor instance

    ClassicEditor
        .create(document.querySelector('#entry-editor-content'),{
                ckfinder: {
                        uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                    }
            }
            )
        .then(newEditor => {
            editor = newEditor;
            console.log('CKEditor initialized and editor assigned:', editor);
        })
        .catch(error => {
            console.error('CKEditor initialization error:', error);
        });

     let editormodal;

     ClassicEditor
        .create(document.querySelector('#entry-editor-content-edit'),{
                ckfinder: {
                        uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                    }
            }
            )
        .then(newEditor => {
            editormodal = newEditor;
            console.log('CKEditor initialized and editor assigned:', editormodal);
        })
        .catch(error => {
            console.error('CKEditor initialization error:', error);
        });


     
     

    function saveHeaderFooter() {
        if (!editor) {
            console.error('CKEditor is not initialized or editor is not assigned.');
            return;
        }

        var name = document.getElementById('entry-name').value;
        var type = document.getElementById('entry-type').value;
        var editorContent = editor.getData(); // Get CKEditor content
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


        $.ajax({
            url: '/header-and-footer/save',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                name: name,
                type: type,
                editor_content: editorContent
            },
            success: function(response) {
                if (response.success) {
                    // Handle success, maybe show a message
                    location.reload();
                } else {
                    console.error('Error saving header/footer entry: ', response.message);
                }
            },
            error: function(error) {
                console.error('Error saving header/footer entry: ', error.responseText);
            }
        });
    }



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

    $('#exampleModalNew').modal('hide');
 
    function openModal(entryId, name, type, editorContent) {
        var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
        myModal.show();

        // Set values in the modal form
        document.getElementById('entry-id-edit').value = entryId;
        document.getElementById('entry-name-edit').value = name;
        document.getElementById('entry-type-edit').value = type;
       // document.getElementById('entry-editor-content-edit').value = editorContent;
        editormodal.setData(editorContent);
    }

    $('#exampleModal').modal('hide');

     
 

       // Function to handle entry edit
       function editEntry() {
        var id = document.getElementById('entry-id-edit').value;
        var name = document.getElementById('entry-name-edit').value;
        var type = document.getElementById('entry-type-edit').value;
        var editorContent = editormodal.getData(); // Get CKEditor content
         

        // AJAX request to update the entry
        $.ajax({
            url: '/header-and-footer/update/' + id, // Update the URL to match your Laravel route
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}', // Add CSRF token for Laravel
                'name': name,
                'type': type,
                'editor_content': editorContent
            },
            success: function (data) {
                // Handle success, for example, close the modal
                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                myModal.hide();
                // You can perform additional actions here if needed
                location.reload(); // Reload the page to reflect changes
            },
            error: function (error) {
                // Handle error
                console.error('Error updating header/footer entry:', error);
            }
        });
    }


</script>

@endsection

