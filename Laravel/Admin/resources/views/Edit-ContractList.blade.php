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
           Edit Contract List 
        @endslot
    @endcomponent
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 

 <script>

window.onbeforeunload = function() {
    var message = 'Do you want to leave this page?';
    return message;
}
 </script>
     
    <!-- Header Or Footer modal working one  with below script-->
    <div class="modal" id="HeaderOrFooterModal" tabindex="-1" aria-labelledby="HeaderOrFooterModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="HeaderOrFooterModalLabel">Header/Footer Entries</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="checkbox" id="checkbox1" onchange="toggleDropdowns('checkbox1', 'dropdown1', 'dropdown2')"> Header
                        <div class="row">
                            <div class="col">
                                <select id="dropdown1" class="form-select" style="display: none;">
                                    @foreach($headerEntries as $id => $header)
                                        <option value="{{ $id }}">{{ $header }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select id="dropdown2" class="form-select" style="display: none;">
                                    <option value="first">First Page</option>
                                    <option value="every">Every Page</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" id="checkbox2" onchange="toggleDropdowns('checkbox2', 'dropdown3', 'dropdown4')"> Footer
                        <div class="row">
                            <div class="col">
                                <select id="dropdown3" class="form-select" style="display: none;">
                                    @foreach($footerEntries as $id => $footer)
                                        <option value="{{ $id }}">{{ $footer }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select id="dropdown4" class="form-select" style="display: none;">
                                    <option value="first">First Page</option>
                                    <option value="every">Every Page</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openHeaderOrFooterModal() {
            var myModal = new bootstrap.Modal(document.getElementById('HeaderOrFooterModal'));
            myModal.show();
        }

        function toggleDropdowns(checkboxId, dropdownId1, dropdownId2) {
            var checkbox = document.getElementById(checkboxId);
            var dropdown1 = document.getElementById(dropdownId1);
            var dropdown2 = document.getElementById(dropdownId2);

            if (checkbox.checked) {
                dropdown1.style.display = 'block';
                dropdown2.style.display = 'block';
            } else {
                dropdown1.style.display = 'none';
                dropdown2.style.display = 'none';
            }
        }
    </script>

    <div class="card">
            <div class="card-body">
                <form id="editpagenew">
                    <input type="hidden" id="contract-id" value="{{ $contract->id }}">
                    
                     <!-- For larger screens (md and above) -->
                     <div class="d-none d-md-flex align-items-center mb-3">
                            <label for="title" class="form-label me-2" style="width: 120px;">Contract Name</label>
                            <input type="text" class="form-control w-75" id="title" name="contract_name" value="{{ $contract->contract_name }}">
                            
                            <div class="dropdown" style="margin-left: 3px;">
                                <button type="button" class="btn btn-primary dropdown-toggle btn-lg" data-bs-toggle="dropdown" aria-expanded="false">
                                    All Actions <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li><button class="dropdown-item" type="button" onclick="previewPDF()">Preview</button></li>
                                    <li><button class="dropdown-item" type="button" onclick="openHeaderOrFooterModal()">Header/Footer</button></li>
                                    <li><button class="dropdown-item" type="button" onclick="openpricemodal('{{$contract->id}}')">Add Price</button></li>
                                    <li><button class="dropdown-item" type="button" onclick="openproductmodal()">Product</button></li>
                                    <li><button class="dropdown-item" type="button" onclick="openModalNew('{{$contract->id}}')">Variable</button></li>
                                    <li><button class="dropdown-item" type="button" id="signbutton">Signature</button></li>
                                    <!-- <li><button class="dropdown-item" type="button" onclick="saveData()">Update</button></li> -->
                                </ul>
                            </div>
                        
                            <button type="button" class="btn btn-success me-2 btn-lg" style="margin-left: 2px;" onclick="saveData()">Update</button>
                        </div>
                        
                        <div class="d-md-none mb-3">
                            <!-- Insert the responsive HTML code here  lower screen-->
                            
                            <div class="d-flex flex-wrap align-items-center mb-3">
                            <label for="title" class="form-label me-2" style="flex: 0 0 120px;">Contract Name</label>
                            <input type="text" class="form-control flex-grow-1 mb-2 mb-md-0" id="title" name="contract_name" value="{{ $contract->contract_name }}">
                            
                            <div class="dropdown" style="margin-left: 3px;">
                                <button type="button" class="btn btn-primary dropdown-toggle btn-lg" data-bs-toggle="dropdown" aria-expanded="false">
                                    All Actions <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <li><button class="dropdown-item" type="button" onclick="previewPDF()">Preview</button></li>
                                    <li><button class="dropdown-item" type="button" onclick="openHeaderOrFooterModal()">Header/Footer</button></li>
                                    <li><button class="dropdown-item" type="button" onclick="openpricemodal('{{$contract->id}}')">Add Price</button></li>
                                    <li><button class="dropdown-item" type="button" onclick="openproductmodal()">Product</button></li>
                                    <li><button class="dropdown-item" type="button" onclick="openModalNew('{{$contract->id}}')">Variable</button></li>
                                    <li><button class="dropdown-item" type="button" id="signbutton">Signature</button></li>
                                    <!-- <li><button class="dropdown-item" type="button" onclick="saveData()">Update</button></li> -->
                                </ul>
                            </div>
                        
                            <button type="button" class="btn btn-success btn-lg" style="margin-left: 2px;" onclick="saveData()">Update</button>
                        </div>
                    </div>

                <!-- For licensed CKEditor 
                     <div id="presence-list-container"></div>
                    <div id="editor-container">
                        <div class="container">
                            <div id="outline" class="document-outline-container"></div>
                          
                        </div>
                    </div> -->

            <textarea id="editor" name="editor" style="width: 100%; max-width: 500px;">{{ $contract->editor_content }}</textarea>
          

                    <style>
                        
                        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
                            border-color: var(--ck-color-base-border);
                            height: 500px !important;

                            width : 100% !important;
             
                                
                                }
                                .ck.ck-editor__editable_inline>:last-child {
                                    margin-bottom: var(--ck-spacing-large);
                                    height: 500px;
                            
                                }

                                .ck-editor__editable {
                                    min-height: 500px;
                                   
                                }
                        </style>
               
                </form>
            </div>
        </div>

        <!-- 
        <script>
            $(document).ready(function() {
                    $('.add-checkbox').each(function() {
                        var variableId = $(this).data('variable-id');
                        var isChecked = localStorage.getItem('isChecked_' + variableId);
                        if (isChecked === 'true') {
                            $(this).prop('checked', true);
                        }
                    });
                });
        </script> 
        -->



<script>
//variable pop up search
$(document).ready(function () {
        // Reference to the input field and the table
        var $searchInput = $('#searchInputvariable');
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

 
       <!--  for select product modal checkbox -->
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

    <!-- price Modal -->
    <div class="modal" id="exampleModalPrice" tabindex="-1" aria-labelledby="exampleModalLabelNew" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelNew">Price List</h5>
                    <div class="col-sm">
                        <div class="search-box me-2 d-inline-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" autocomplete="off" id="searchInputprice" placeholder="Search...">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                    <form id="priceFormNew" action="/get-price-lists" method="POST">
                        <!-- for table -->
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <table id="PriceList" action="/get-price-lists" method="POST" class="table">
                            <thead>
                                <tr>
                                    <th>Price ID</th>
                                    <th>price Name</th>
                                    <th>Currency</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($priceLists as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->pricename }}</td>
                                    <td>{{ $product->currency }}</td>
                                    <td>
                                        <!-- Checkbox to select product -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$contract->id}},{{ $product->id }},{{ $product->pricename }}" id="priceCheckbox_{{ $product->id }}" name="selectedPrice">
                                            <!-- <label class="form-check-label" for="priceCheckbox_{{ $product->id }}">
                                                Add
                                            </label> -->
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                   <button type="button" class="btn btn-primary" onclick="" id="addPriceButton" data-bs-dismiss="modal" disabled>Add</button>

                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary" onclick="">Save Product</button> -->
                </div>
            </div>
        </div>
    </div>

 
<!--  for select price modal checkbox -->
    <script>
        
         document.addEventListener("DOMContentLoaded", function() {
            var checkboxes = document.querySelectorAll('#exampleModalPrice input[type="checkbox"]');
            var addPriceButton = document.getElementById('addPriceButton');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    checkboxes.forEach(function(cb) {
                        if (cb !== checkbox) {
                            cb.checked = false;
                        }
                    });

                    if (checkbox.checked) {
               
                        addPriceButton.disabled = false;
                        var selectedPriceId = null;
                        // Splitting the value to get both contractId and productId
                        var ids = checkbox.value.split(',');
                        console.log('my value :' ,ids );
                        selectedPriceId = {
                            contractId: ids[0],
                            productId: ids[1],
                            pricename: ids[2]
                        };
                        console.log('selectedPriceId :', selectedPriceId);
                        // addPriceButton.addEventListener('click', function() {
                        //     // call insertprice logic when the button is clicked
                        //     insertprice(selectedPriceId.pricename);
                        //     console.log('Add button clicked!');
                        // });
                        // insert $PRICE$ in Ckeditor 

                        var csrfToken = $('meta[name="csrf-token"]').attr('content');    
                        if (selectedPriceId !== null) {
                            $.ajax({
                                url: '/insert-price-id', // Replace with your route
                                method: 'POST',
                                data: {
                                    contractId: selectedPriceId.contractId,
                                    productId: selectedPriceId.productId
                                },
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                success: function(response) {
                                    // Handle success response
                                    console.log(response);
                                },
                                error: function(xhr, status, error) {
                                    // Handle error
                                    console.error('Error:', error);
                                }
                            });
                        }
                    }   
                    else {
                        addPriceButton.disabled = true;
                        // If checkbox is unchecked, trigger AJAX call to delete price ID
                        var selectedPriceId = null;
                        var ids = checkbox.value.split(',');
                        selectedPriceId = {
                            contractId: ids[0],
                            productId: ids[1]
                        };

                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            url: '/delete-price-id', // Replace with your delete route
                            method: 'POST',
                            data: {
                                contractId: selectedPriceId.contractId
                            },
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(response) {
                                // Handle success response
                                console.log(response);
                                // Show confirmation dialog
                                var confirmed = window.confirm("Do you want to delete the price?");
                                if (confirmed) {
                                    deletePriceFromCKEditor();
                                } else {
                                  //  addPriceButton.disabled = false;
                                  //  checkbox.checked = true;
                                }
                                $('#exampleModalPrice').modal('hide');
                            },
                            error: function(xhr, status, error) {
                                // Handle error
                                console.error('Error:', error);
                            }
                        });
                    }

                });
            });
        });

        //addPriceButton.removeEventListener('click', arguments.callee);
        // addPriceButton.addEventListener('click', function(event) {
        //                     // call insertprice logic when the button is clicked
        //                     var price = 'price';
        //                     insertprice(price);
        //                     console.log('Add button clicked! 1st time');
        //                     // Remove the event listener after it has been triggered
        //                     addPriceButton.removeEventListener('click', arguments.callee);
        // });

        $(document).ready(function () {
        // Reference to the input field and the table
        var $searchInput = $('#searchInputprice');
        var $table = $('#PriceList');

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

@endsection

@section('script')
<!-- <script src="https://cdn.ckbox.io/CKBox/2.2.0/ckbox.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/super-build/ckeditor.js"></script> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- image resize CDN but not good
    <script src="https://cdn.jsdelivr.net/npm/ckeditor5-build-classic-with-image-resize@12.4.0/build/ckeditor.min.js"></script> -->
<!--  decoupled document CSKEDitor  -->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/decoupled-document/ckeditor.js"></script> -->

<!--  classic CSKEDitor  
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>  -->

<!--  classic CSKEDitor custom build  -->
<script src="{{ asset('js/ckeditor/build/ckeditor.js') }}"></script>
<script>
       
       let editor; // Global variable for main CKEditor instance    
         
        
        ClassicEditor
            .create(document.querySelector('#editor'),{
          
                ckfinder: {
                        uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                    },
                // testing image resize plugins 
                // plugins: [Image, ImageResize],
                // toolbar: ['imageResize', '|', 'imageUpload', '|', 'undo', 'redo']
            }
            )
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

                window.insertprice = function(variableName) {
                    // Insert variableName at the current cursor position
                    const currentPosition = editor.model.document.selection.getLastPosition();
                    var priceString = 'PRICE';
                    if (currentPosition) {
                        editor.model.change(writer => {
                            writer.insertText("$"+priceString+"$", currentPosition);
                        });
                    }
                }
            })
            .catch(error => {
                console.error(error);
            });
               
            // Signature button method
            $(document).ready(function() {
                $('#signbutton').click(function() {
                    const imageUrl = 'firma.jpg';
                   // const img = "<img src='" + imageUrl + "'/>";
                  //  const img = "<img src='https://www.redballoontoystore.com/cdn/shop/products/Playground-Ball-OutdoorActive-Schylling_460x@2x.jpg?v=1651770584'/>";
                  const img = "<img src='https://i.ibb.co/71g553C/FIRMA-QUI.jpg'/>";
                    const previousContent = editor.getData();
                    const currentPosition = editor.model.document.selection.getLastPosition();
                    
                    if (currentPosition) {
                        const newData = previousContent + img;
                        editor.data.set(newData, { position: currentPosition });
                    }
                });
            });

        //     function previewPDF() {
        //     // Get data from CKEditor
        //     var editorData = editor.getData();

        //     // Convert HTML content to PDF using jQuery
        //     var myWindow = window.open('', 'PRINT', 'height=600,width=800');

        //     myWindow.document.write('<html><head><title>PDF Preview</title>');
        //     myWindow.document.write('</head><body>');
        //     myWindow.document.write(editorData);
        //     myWindow.document.write('</body></html>');

        //     myWindow.document.close(); // necessary for IE >= 10
        //     myWindow.onload = function () {
        //         myWindow.print();
        //         myWindow.close();
        //     };
        // }

        // Function to delete "$PRICE$" string from CKEditor content
        function deletePriceFromCKEditor() {
            var priceRegex = /\$PRICE\$/g; // Regular expression to match all occurrences of "$PRICE$"
            var editorData = editor.getData();
            var newData = editorData.replace(priceRegex, ''); // Replace all occurrences of "$PRICE$" with an empty string
            editor.data.set(newData, { suppressErrorInCollaboration: true });
            console.log('I am here at deletePriceFromCKEditor');
        }


        function previewPDF() {
            // Get data from CKEditor
            var editorData = editor.getData();

            // Get selected header or footer data
            var headerDropdown = document.getElementById('dropdown1');
            var footerDropdown = document.getElementById('dropdown3');
           //var headerValue = headerDropdown.options[headerDropdown.selectedIndex].text;
           // var footerValue = footerDropdown.options[footerDropdown.selectedIndex].text;

            var headerValue = headerDropdown.selectedIndex !== -1 ? headerDropdown.options[headerDropdown.selectedIndex].text : null;
            var footerValue = footerDropdown.selectedIndex !== -1 ? footerDropdown.options[footerDropdown.selectedIndex].text : null;


            // Determine if header or footer is selected for first or every page
            var headerLocation = document.getElementById('dropdown2').value;
            var footerLocation = document.getElementById('dropdown4').value;

            // Check if header checkbox is checked
            var headerCheckbox = document.getElementById('checkbox1').checked;

            // Check if footer checkbox is checked
            var footerCheckbox = document.getElementById('checkbox2').checked;

            // Construct title text including selected header or footer values
            var titleHeader = "";
            var titleFooter = "";

            // Construct header and footer based on selection
            var headerHTML = '';
            var footerHTML = '';

            // Include header if checkbox is checked and it's selected for the first page or every page
            if (headerCheckbox) {
                if (headerLocation === 'first' || headerLocation === 'every') {
                    titleHeader += headerValue  ;
                    headerHTML = '<div style="position: fixed; top: 20px; right: 20px;">' + headerValue + '</div>';
                }
            }

            // Include footer if checkbox is checked and it's selected for the first page or every page
            if (footerCheckbox) {
                if (footerLocation === 'first' || footerLocation === 'every') {
                    titleFooter += footerValue + " - " + footerLocation;
                    footerHTML = '<div style="position: fixed; bottom: 5px; right: 20px;">' + footerValue +  '</div>';
                }
            }

            // Convert HTML content to PDF using jQuery
            var myWindow = window.open('', 'PRINT', 'height=600,width=800');

            myWindow.document.write('<html><title style="text-align:right">' + 
        "Codice 1% PDF &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+  titleHeader +'</title>');
            myWindow.document.write('<style>@page { margin: 100px; counter-reset: page-counter; }</style>'); // Reset page counter
            myWindow.document.write('</head><body>');

            // Increment page counter for each page
            myWindow.document.write('<div style="position: absolute; top: -50px; right: 50px;">Page: <span style="counter-increment: page-counter; content: counter(page-counter);"></span></div>');

            // Write editor data
            myWindow.document.write(editorData);

            // Include footer based on selection
            myWindow.document.write('</body><footer>' + footerHTML + '</footer></html>');

            myWindow.document.close(); // necessary for IE >= 10
            myWindow.onload = function () {
                myWindow.print();
                myWindow.close();
            };
        }


        // for open product modal 
        function openproductmodal() {
            // Using Bootstrap's JavaScript to open the product list modal
            var myModal = new bootstrap.Modal(document.getElementById('exampleModalProduct'));
            myModal.show();
        }
        $('#exampleModalProduct').modal('hide');


    
        
        let arifurData = false;
        let previousContent = '';

        window.addEventListener('beforeunload', function (e) {
            if (!arifurData) {
                const confirmationMessage = 'You have unsaved changes. Are you sure you want to leave?';
                (e || window.event).returnValue = confirmationMessage;
                return confirmationMessage;
            }
        });

        function saveData() {
        // Check if CKEditor is initialized
        if (!editor) {
            console.error('CKEditor is not initialized.');
            return;
        }

        // Get the contract ID from the hidden input field
        const contractId = document.querySelector('#contract-id').value;

        // Get the contract name from the input field
        const contractName = document.querySelector('#title').value;

        // Check if the contract name is empty
        if (!contractName.trim()) {
            console.error('Contract name cannot be empty.');
            return;
        }

        // Get the editor content from CKEditor
        const editorContent = editor.getData();

       

        // Prepare the form data
        const formData = {
            _token: "{{ csrf_token() }}",
            id: contractId,
            contract_name: contractName,
            editor_content: editorContent
        };

        // Call the saveContent function to save the data
          saveContent(formData);
          arifurData = true;
    }

    function saveContent(formData) {
    $.ajax({
        url: '/edit-contract-list/update', // Change the URL to the update route
        type: 'POST',
        data: formData,
        success: function(response) {
            alert(response.message);
           // toastr.success("The data is updated"); 
           // window.location.href = "/Contract-List";
            console.log(response);
            // Optionally, you can redirect or show a success message here
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Optionally, you can handle errors here
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
    

function checkCheckbox(checkbox, variableName,  variableId) {
    var $row = $(checkbox).closest('tr'); // Find the parent row

    if (checkbox.checked) {
   

        $row.find('.add-button').prop('disabled', false); // Enable button if checkbox is checked
           // Send data to server for insertion
        console.log('Logged-in User:', '{{ Auth::user()->name }}');

        const contractId = document.querySelector('#contract-id').value;   
        $.ajax({
                        url: '/insert-contract-variable',
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            contract_id: contractId,
                            variable_id: variableId
                        },
                        success: function(response) {
                            // Store the checked state in localStorage 
                            localStorage.setItem('isChecked_' + variableId, 'true');
                        },

                        error: function(xhr, status, error) {
                             
                        }
                    });
    } else {
    
        var editorData = editor.getData();
        var count = countOccurrences(editorData, variableName);

        if (count===0){
                // Call the AJAX function to delete the contract variable
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var contractId = document.querySelector('#contract-id').value;
                    //const contractId = document.querySelector('#contract-id').value; 
                    $.ajax({
                        url: '/delete-contract-variable',
                        method: 'POST',
                        data: {
                            _token: csrfToken,
                            contract_id: contractId,
                            variable_id: variableId
                        },
                        success: function(response) {
                            // Handle success if needed
                        },
                        error: function(xhr, status, error) {
                            // Handle error if needed
                        }
                    });

        }

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
                    var latestvar = "%" + variableName + "%";
                    editorData = deleteSubstring(editorData, latestvar);
                    editor.data.set(editorData, { suppressErrorInCollaboration: true });

                    // Call the AJAX function to delete the contract variable
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var contractId = document.querySelector('#contract-id').value;
                    //const contractId = document.querySelector('#contract-id').value; 
                    $.ajax({
                        url: '/delete-contract-variable',
                        method: 'POST',
                        data: {
                            _token: csrfToken,
                            contract_id: contractId,
                            variable_id: variableId
                        },
                        success: function(response) {
                            // Handle success if needed
                        },
                        error: function(xhr, status, error) {
                            // Handle error if needed
                        }
                    });

                } else {
                    // If user cancels deletion, recheck the checkbox
                    checkbox.checked = true;
                    $row.find('.add-button').prop('disabled', false); // Enable button as checkbox is checked
                }
            });
        } else {
            // If no occurrences found, enable button directly
            $row.find('.add-button').prop('disabled', false);
        }
    }
}



        //to open price modal
        function openpricemodal(contractID) {
            // AJAX call to retrieve price_id for the given contractID
                $.ajax({
                    url: '/get-price-id', // Replace with your route
                    method: 'GET',
                    data: {
                        contractID: contractID
                    },
                    success: function(response) {
                        // Open the modal
                        var myModal = new bootstrap.Modal(document.getElementById('exampleModalPrice'));
                        myModal.show();

                        // Select the checkbox if price_id is found
                        if (response.price_id) {
                            var checkbox = document.getElementById('priceCheckbox_' + response.price_id);
                            if (checkbox) {
                                checkbox.checked = true;
                                var addPriceButton = document.getElementById('addPriceButton');
                                addPriceButton.disabled = false;
                                //addPriceButton.removeEventListener('click', arguments.callee);
                            

                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error('Error:', error);
                    }
                });

                addPriceButton.addEventListener('click', function() {
                                    // for future ajax call to get pricename and  call insertprice logic when the button is clicked
                                  
                                    insertprice('price');
                                    console.log('Add button clicked!  2nd time  ' );
                                       // Remove the event listener after it has been triggered
                                    addPriceButton.removeEventListener('click', arguments.callee);
                                    
                                });
            }

 
            function openModalNew(contractID, variableIDs) {
            // AJAX request to retrieve variable IDs
            $.ajax({
                url: '/checkedVariable',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    contract_id: contractID
                },
                success: function(response) {
                    // Loop through the response data
                    response.forEach(function(variableID) {
                        // Find the checkbox corresponding to the variableID in the table and check it
                        $('tbody tr').each(function() {
                            var rowVariableID = $(this).find('td:first').text().trim(); // Get the VariableID of the current row
                            if (rowVariableID === variableID) {
                                $(this).find('.add-checkbox').prop('checked', true);
                                $(this).find('.add-button').prop('disabled', false);
                            }
                        });
                    });

                    // Open the modal with the retrieved variable IDs
                    var myModal = new bootstrap.Modal(document.getElementById('exampleModalNew'));
                    myModal.show(); // Open the modal

                    // Delegate the change event handling to the tbody element
                    $('tbody').on('change', '.add-checkbox', function() {
                        // Find the parent row of the checkbox
                        var $row = $(this).closest('tr');
                        // Find the add button within the same row and enable/disable it based on the checkbox state
                        $row.find('.add-button').prop('disabled', !$(this).prop('checked'));
                    });
                },
                error: function(xhr, status, error) {
                    // Handle error
                }
            });
        }


        
        $('#exampleModalNew').modal('hide');

 
</script>

<!-- variable Modal -->
<div class="modal" id="exampleModalNew" tabindex="-1" aria-labelledby="exampleModalLabelNew" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelNew">Variable List</h5>
                <div class="col-sm">
                    <div class="search-box me-2 d-inline-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" autocomplete="off" id="searchInputvariable" placeholder="Search...">
                            <i class="bx bx-search-alt search-icon"></i>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productFormNew" action="/edit-contract-list" method="POST" >
                    <!-- for table -->
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <!-- Wrap the table inside a div with fixed height and auto scroll -->
                    <div style="max-height: 400px; overflow-y: auto;">
                        <table id="ContractList" action="/edit-contract-list" method="POST" class="table">
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
                                           
                                        <!-- <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input add-checkbox"
                                                    onchange="checkCheckbox(this, '{{ $contract->VariableName }}' , '{{ $contract->VariableID }}')">
                                        </label>  -->

                                        <!-- <label class="form-check-label">
                                            <input id="variablecheckbox" type="checkbox" class="form-check-input add-checkbox"
                                                onchange="checkCheckbox(this,'{{ $contract->VariableName }}' , '{{ $contract->VariableID }}')">
                                        </label> -->

                                        <label class="form-check-label">
                                            <input id="variablecheckbox" class="variable-checkbox form-check-input add-checkbox" type="checkbox" onchange="checkCheckbox(this,'{{ $contract->VariableName }}' , '{{ $contract->VariableID }}')">
                                        </label>


                                            <button type="button" class="btn btn-primary add-button"
                                                data-bs-dismiss="modal" onclick="insertVariable('{{ $contract->VariableName }}')" disabled>Add</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                <!-- <button type="button" class="btn btn-primary" onclick="">Save Product</button>   , '{{ $contract->id }}' , '{{ $contract->VariableID }}'  --> 
            </div>
        </div>
    </div>
</div>

 
@endsection
 






<!-- 
// CKEDITOR.ClassicEditor.create( document.querySelector( '#editor' ), {
// // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
// toolbar: {
//     items: [
//         'aiCommands', 'aiAssistant', '|',
//         'ckbox', 'uploadImage', '|',
//         'exportPDF','exportWord', '|',
//         'comment', 'trackChanges', 'revisionHistory', '|',
//         'findAndReplace', 'selectAll', 'formatPainter', '|',
//         'undo', 'redo',
//         '-',
//         'bold', 'italic', 'strikethrough', 'underline', 'removeFormat', '|',
//         'bulletedList', 'numberedList', 'todoList', '|',
//         'outdent', 'indent', '|',
//         'alignment', '|',
//         '-',
//         'heading', '|',
//         'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
//         'link', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', 'tableOfContents', 'insertTemplate', '|',
//         'specialCharacters', 'horizontalLine', 'pageBreak', '|',
//         // Intentionally skipped buttons to keep the toolbar smaller, feel free to enable them:
//         // 'code', 'subscript', 'superscript', 'textPartLanguage', '|',
//         // ** To use source editing remember to disable real-time collaboration plugins **
//         // 'sourceEditing'
//     ],
//     shouldNotGroupWhenFull: true
// },
// // Changing the language of the interface requires loading the language file using the <script> tag.
// // language: 'es',
// list: {
//     properties: {
//         styles: true,
//         startIndex: true,
//         reversed: true
//     }
// },
// // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
// heading: {
//     options: [
//         { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
//         { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
//         { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
//         { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
//         { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
//         { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
//         { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
//     ]
// },
// // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
// fontFamily: {
//     options: [
//         'default',
//         'Arial, Helvetica, sans-serif',
//         'Courier New, Courier, monospace',
//         'Georgia, serif',
//         'Lucida Sans Unicode, Lucida Grande, sans-serif',
//         'Tahoma, Geneva, sans-serif',
//         'Times New Roman, Times, serif',
//         'Trebuchet MS, Helvetica, sans-serif',
//         'Verdana, Geneva, sans-serif'
//     ],
//     supportAllValues: true
// },
// // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
// fontSize: {
//     options: [ 10, 12, 14, 'default', 18, 20, 22 ],
//     supportAllValues: true
// },
// // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
// // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
// // htmlSupport: {
// // 	allow: [
// // 		{
// // 			name: /.*/,
// // 			attributes: true,
// // 			classes: true,
// // 			styles: true
// // 		}
// // 	]
// // },
// // Be careful with enabling previews
// // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
// htmlEmbed: {
//     showPreviews: true
// },
// // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
// mention: {
//     feeds: [
//         {
//             marker: '@',
//             feed: [
//                 '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
//                 '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
//                 '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
//                 '@sugar', '@sweet', '@topping', '@wafer'
//             ],
//             minimumCharacters: 1
//         }
//     ]
// },
// template: {
//     definitions: [
//         {
//             title: 'The title of the template',
//             description: 'A longer description of the template',
//             data: '<p>Data inserted into the content</p>'
//         },
//         {
//             title: 'Annual financial report',
//             description: 'A report that spells out the company\'s financial condition.',
//             data: `<figure class="table">
//                 <table style="border:2px solid hsl(0, 0%, 0%);">
//                     <thead>
//                         <tr>
//                             <th style="text-align:center;" rowspan="2">Metric name</th>
//                             <th style="text-align:center;" colspan="4">Year</th>
//                         </tr>
//                         <tr>
//                             <th style="background-color:hsl(90, 75%, 60%);text-align:center;">2019</th>
//                             <th style="background-color:hsl(90, 75%, 60%);text-align:center;">2020</th>
//                             <th style="background-color:hsl(90, 75%, 60%);text-align:center;">2021</th>
//                             <th style="background-color:hsl(90, 75%, 60%);text-align:center;">2022</th>
//                         </tr>
//                     </thead>
//                     <tbody>
//                         <tr>
//                             <th><strong>Revenue</strong></th>
//                             <td>$100,000.00</td>
//                             <td>$120,000.00</td>
//                             <td>$130,000.00</td>
//                             <td>$180,000.00</td>
//                         </tr>
//                         <tr>
//                             <th style="background-color:hsl(0, 0%, 90%);"><strong>Operating expenses</strong></th>
//                             <td>&nbsp;</td>
//                             <td>&nbsp;</td>
//                             <td>&nbsp;</td>
//                             <td>&nbsp;</td>
//                         </tr>
//                         <tr>
//                             <th><strong>Interest</strong></th>
//                             <td>&nbsp;</td>
//                             <td>&nbsp;</td>
//                             <td>&nbsp;</td>
//                             <td>&nbsp;</td>
//                         </tr>
//                         <tr>
//                             <th style="background-color:hsl(0, 0%, 90%);"><strong>Net profit</strong></th>
//                             <td>&nbsp;</td>
//                             <td>&nbsp;</td>
//                             <td>&nbsp;</td>
//                             <td>&nbsp;</td>
//                         </tr>
//                     </tbody>
//                 </table>
//             </figure>`
//         },
//     ]
// },
// // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
// placeholder: 'Welcome to CKEditor 5!',
// // Used by real-time collaboration
// cloudServices: {
//     // Be careful - do not use the development token endpoint on production systems!
//     tokenUrl: 'https://106148.cke-cs.com/token/dev/1qI5VmPbaqDXGW5M1eC5eimn9UpgbehBUars?limit=10',
//     webSocketUrl: 'wss://106148.cke-cs.com/ws',
//     uploadUrl: 'https://106148.cke-cs.com/easyimage/upload/'
// },
// collaboration: {
//     // Modify the channelId to simulate editing different documents
//     // https://ckeditor.com/docs/ckeditor5/latest/features/collaboration/real-time-collaboration/real-time-collaboration-integration.html#the-channelid-configuration-property
//     channelId: 'document-id-7'
// },
// // https://ckeditor.com/docs/ckeditor5/latest/features/collaboration/annotations/annotations-custom-configuration.html#sidebar-configuration
// sidebar: {
//     container: document.querySelector( '#sidebar' )
// },
// documentOutline: {
//     container: document.querySelector( '#outline')
// },
// // https://ckeditor.com/docs/ckeditor5/latest/features/collaboration/real-time-collaboration/users-in-real-time-collaboration.html#users-presence-list
// presenceList: {
//     container: document.querySelector( '#presence-list-container' )
// },
// // Add configuration for the comments editor if the Comments plugin is added.
// // https://ckeditor.com/docs/ckeditor5/latest/features/collaboration/annotations/annotations-custom-configuration.html#comment-editor-configuration
// comments: {
//     editorConfig: {
//         extraPlugins: CKEDITOR.ClassicEditor.builtinPlugins.filter( plugin => {
//             // Use e.g. Ctrl+B in the comments editor to bold text.
//             return [ 'Bold', 'Italic', 'Underline', 'List', 'Autoformat', 'Mention' ].includes( plugin.pluginName );
//         } ),
//         // Combine mentions + Webhooks to notify users about new comments
//         // https://ckeditor.com/docs/cs/latest/guides/webhooks/events.html
//         mention: {
//             feeds: [
//                 {
//                     marker: '@',
//                     feed: [
//                         '@Baby Doe', '@Joe Doe', '@Jane Doe', '@Jane Roe', '@Richard Roe'
//                     ],
//                     minimumCharacters: 1
//                 }
//             ]
//         },
//     }
// },
// // Do not include revision history configuration if you do not want to integrate it.
// // Remember to remove the 'revisionHistory' button from the toolbar in such a case.
// revisionHistory: {
//     editorContainer: document.querySelector( '#editor-container' ),
//     viewerContainer: document.querySelector( '#revision-viewer-container' ),
//     viewerEditorElement: document.querySelector( '#revision-viewer-editor' ),
//     viewerSidebarContainer: document.querySelector( '#revision-viewer-sidebar' ),
// },
// // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/ckbox.html
// ckbox: {
//     // Be careful - do not use the development token endpoint on production systems!
//     tokenUrl: 'https://106148.cke-cs.com/token/dev/1qI5VmPbaqDXGW5M1eC5eimn9UpgbehBUars?limit=10'
// },
// // AI Assistant feature configuration.
// // https://ckeditor.com/docs/ckeditor5/latest/features/ai-assistant.html
// aiAssistant: {
// //     // Provide the URL to the OpenAI proxy endpoint in your application.
// //     apiUrl: 'http://url-to-your-openai-proxy-endpoint/'
// },
// style: {
//     definitions: [
//         {
//             name: 'Article category',
//             element: 'h3',
//             classes: [ 'category' ]
//         },
//         {
//             name: 'Info box',
//             element: 'p',
//             classes: [ 'info-box' ]
//         },
//     ]
// },
// // License key is required only by the Pagination plugin and non-realtime Comments/Track changes.
// licenseKey: 'dmkwQkd1OU1DUDM1ZjF6ZUZySjRiRU1jSmNJemIxNi9Ta3Z3SDZHNGZRZjlhWlpFVkhYekJmSHpGZnlFLU1qQXlOREF6TWpjPQ==',
// removePlugins: [
//     // Before enabling Pagination plugin, make sure to provide proper configuration and add relevant buttons to the toolbar
//     // https://ckeditor.com/docs/ckeditor5/latest/features/pagination/pagination.html
//     'Pagination',
//     // Intentionally disabled, file uploads are handled by CKBox
//     'Base64UploadAdapter',
//     // Intentionally disabled, file uploads are handled by CKBox
//     'CKFinder',
//     // Intentionally disabled, file uploads are handled by CKBox
//     'EasyImage',
//     // Requires additional license key
//     'WProofreader',
//     // Incompatible with real-time collaboration
//     'SourceEditing',
//     // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
//     // from a local file system (file://) - load this site via HTTP server if you enable MathType
//     'MathType'
//     // If you would like to adjust enabled collaboration features:
//     // 'RealTimeCollaborativeComments',
//     // 'RealTimeCollaborativeTrackChanges',
//     // 'RealTimeCollaborativeRevisionHistory',
//     // 'PresenceList',
//     // 'Comments',
//     // 'TrackChanges',
//     // 'TrackChangesData',
//     // 'RevisionHistory',
// ]
// } )
//         .then(createdEditor => {
//             // Assign the created editor to the global variable
//             editor = createdEditor;

//             // Define a function to insert text into CKEditor 5
//             window.insertVariable = function(variableName) {
//                 // Insert variableName at the current cursor position
//                 const currentPosition = editor.model.document.selection.getLastPosition();
//                 if (currentPosition) {
//                     editor.model.change(writer => {
//                         writer.insertText("%"+variableName+"%", currentPosition);
//                     });
//                 }
//             }
//             window.editor = editor;
//             const annotationsUIs = editor.plugins.get( 'AnnotationsUIs' );
//             const sidebarElement = document.querySelector( '.sidebar' );
//             let currentWidth;

//             function refreshDisplayMode() {
//                 // Check the window width to avoid the UI switching when the mobile keyboard shows up.
//                 if ( window.innerWidth === currentWidth ) {
//                     return;
//                 }
//                 currentWidth = window.innerWidth;

//                 if ( currentWidth < 1000 ) {
//                     sidebarElement.classList.remove( 'narrow' );
//                     sidebarElement.classList.add( 'hidden' );
//                     annotationsUIs.switchTo( 'inline' );
//                 }
//                 else if ( currentWidth < 1300 ) {
//                     sidebarElement.classList.remove( 'hidden' );
//                     sidebarElement.classList.add( 'narrow' );
//                     annotationsUIs.switchTo( 'narrowSidebar' );
//                 }
//                 else {
//                     sidebarElement.classList.remove( 'hidden', 'narrow' );
//                     annotationsUIs.switchTo( 'wideSidebar' );
//                 }
//             }
//             editor.ui.view.listenTo( window, 'resize', refreshDisplayMode );
//             refreshDisplayMode();

//             return editor;
            
//             })
//             .catch(error => {
//                 console.error(error);
//             }); -->

