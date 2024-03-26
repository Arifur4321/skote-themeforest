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
            Price List 
        @endslot
    @endcomponent
    <!--code starts here --> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> 


 <!--  Arifur change  -->
 <!-- <div class="row">
            <div class="col-sm">
                <div class="search-box me-2 d-inline-block">
              <div class="position-relative">
                        <input type="text" class="form-control" autocomplete="off" id="searchInput" placeholder="Search...">
                        <i class="bx bx-search-alt search-icon"></i>
                    </div>  
                </div>
            </div>
    </div> -->
<!-- two div one will be 75% of screen and another on will be 25%  of screen-->


 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
 
 
    <div class="container-fluid">
        <div class="row">
            <div class="col-9 bg-light"> <!-- 75% width -->
      





  <!--Price Name and  Currency  -->

  <div class="row mt-3">
    <div class="col-sm">
        <div class="input-group">
            <span class="input-group-text">Price Name:</span>
            <input type="text" id="priceName" name="priceName" class="form-control" aria-label="Price Name" value="{{$priceList->pricename }}" required>
        </div>
    </div>
</div>

  <!-- <div class="row mt-3">
    <div class="col-sm d-flex align-items-center">
        <label for="priceName" class="col-form-label me-3">Price Name :</label>
        <input type="text" id="priceName" name="priceName" class="form-control w-25" value="{{$priceList->pricename }}">
    </div>
</div> -->

<!-- Added margin-top for spacing -->

<!-- <div class="row mt-3">
    <div class="col-sm">
        <div class="input-group">
            <label class="input-group-text" for="currency">Select currency:</label>
            <select class="form-select" id="currency" name="currency">
                <option value="EUR" {{ old('currency', 'EUR') === 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>British Pound (GBP)</option>
                <option value="JPY" {{ old('currency') === 'JPY' ? 'selected' : '' }}>Japanese Yen (JPY)</option>
              
            </select>
        </div>
    </div>
</div> -->

<div class="row mt-3">
    <div class="col-sm">
        <div class="input-group">
            <label class="input-group-text" for="currency">Select currency:</label>
            <select class="form-select" id="currency" name="currency">
            <option value="EUR" {{ $priceList->currency === 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
            <option value="USD" {{ $priceList->currency === 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
            <option value="GBP" {{ $priceList->currency === 'GBP' ? 'selected' : '' }}>British Pound (GBP)</option>
            <option value="JPY" {{ $priceList->currency === 'JPY' ? 'selected' : '' }}>Japanese Yen (JPY)</option>
            <!-- Add more currency options as needed -->
            </select>
        </div>
    </div>
</div>


<style>
    .hidden {
        display: none;
    }
    input[type="range"] {
        width: 80%; /* Adjust the width as needed */
    }
</style>

<div class="row mt-3">
    <div class="col-sm">
        <div class="input-group">
            <label class="input-group-text" for="selection">Select an option:</label>
            <select class="form-select" id="selection" name="selection">
                <option value="fixed">Fixed</option>
                <option value="dynamic">Dynamic</option>
            </select>
        </div>
    </div>
    </div>

<!--     
<div class="row mt-3">
    <div class="col-sm d-flex align-items-center">
        <label for="selection">Select an option : </label>
        <select id="selection" name="selection">
            <option value="fixed">Fixed</option>
            <option value="dynamic">Dynamic</option>
        </select>
    </div>
</div> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.js"></script>
 

  <div class="row mt-3">
    <div class="col-sm">


    <div id="fixedInput" class="{{ $priceList->selection === 'fixed' ? '' : 'hidden' }}">
            <div class="mb-3">
                <label for="fixedValue" class="form-label">Enter a fixed value:</label>
                <input type="number" class="form-control w-25" id="fixedValue" name="fixedValue" value="{{ $priceList->fixedvalue }}">
            </div>
        </div>

       

        <div id="dynamicInput" class="{{ $priceList->selection === 'dynamic' ? '' : 'hidden' }}">
             <div class="mb-3">
                <label for="fixedValue2" class="form-label">Enter a fixed value:</label>
                <input type="number" class="form-control w-25" id="fixedValue2" name="fixedValue2" value="{{ $priceList->fixedvalue }}">
            </div>
            <label for="minRange">Min Range:</label>
            <div id="minRangeSlider"></div>
            <span id="minValue">{{ $priceList->dynamicminRange }}</span><br>

            <label for="maxRange">Max Range:</label>
            <div id="maxRangeSlider"></div>
            <span id="maxValue">{{ $priceList->dynamicmaxRange }}</span><br>
        </div> 

 


    </div>
</div>  


<script>
// Initialize min range slider
var minRangeSlider = document.getElementById('minRangeSlider');
noUiSlider.create(minRangeSlider, {
    start: ['{{ $priceList->dynamicminRange }}'],
    connect: 'lower',
    range: {
        'min': 0,
        'max': 10000
    }
});

// Update min value span when slider value changes
minRangeSlider.noUiSlider.on('update', function (values, handle) {
    document.getElementById('minValue').innerHTML = values[handle];
});

// Initialize max range slider
var maxRangeSlider = document.getElementById('maxRangeSlider');
noUiSlider.create(maxRangeSlider, {
    start: ['{{ $priceList->dynamicmaxRange }}'],
    connect: 'lower',
    range: {
        'min': 0,
        'max': 1000000
    }
});

// Update max value span when slider value changes
maxRangeSlider.noUiSlider.on('update', function (values, handle) {
    document.getElementById('maxValue').innerHTML = values[handle];
});


</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const selection = document.getElementById('selection');
    const fixedInput = document.getElementById('fixedInput');
    const dynamicInput = document.getElementById('dynamicInput');

    // Get the value of the selection from the database
    const databaseValue = "{{ $priceList->fixedvalue }}";

    // Set the initial state based on the database value
    if (databaseValue > 0) {
        selection.value = 'fixed';
        fixedInput.classList.remove('hidden');
        dynamicInput.classList.add('hidden');
    } else   {
        selection.value = 'dynamic';
        dynamicInput.classList.remove('hidden');
        fixedInput.classList.add('hidden');
    }

    selection.addEventListener('change', function() {
        if (selection.value === 'fixed') {
            fixedInput.classList.remove('hidden');
            dynamicInput.classList.add('hidden');
        } else if (selection.value === 'dynamic') {
            dynamicInput.classList.remove('hidden');
            fixedInput.classList.add('hidden');
        }
    });

    // Trigger initial state based on the default value of the select element
    if (selection.value === 'fixed') {
        fixedInput.classList.remove('hidden');
        dynamicInput.classList.add('hidden');
    } else if (selection.value === 'dynamic') {
        dynamicInput.classList.remove('hidden');
        fixedInput.classList.add('hidden');
    }
});

function updateMinValue(value) {
    document.getElementById('minValue').innerText = value;
}

function updateMaxValue(value) {
    document.getElementById('maxValue').innerText = value;
}
</script>

 <!-- VAT Section -->
 <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                <input class="form-check-input" type="checkbox" id="vatCheckbox"  name="vatCheckbox"  onchange="toggleVATFields()" {{ $priceList->enableVat === 'true' ? 'checked' : '' }}>
                <label class="form-check-label" for="SwitchCheckSizelg">Enable VAT</label>
    </div>

<!-- <label for="vatCheckbox">Enable VAT:</label>
<input type="checkbox" id="vatCheckbox" name="vatCheckbox" onchange="toggleVATFields()" {{ $priceList->enableVat === 'true' ? 'checked' : '' }}> -->



<div id="vatFields" class="{{ $priceList->enableVat === 'true' ? '' : 'VAThidden' }}">
     
    <div class="mb-3">
        <label for="vatPercentage" class="form-label">VAT Percentage:</label>
        <div class="input-group"  style="width: 25%;">
            <input type="number" id="vatPercentage" name="vatPercentage" class="form-control  " min="0" max="100" value="{{ $priceList->vatPercentage }}" {{ $priceList->enableVat === 'true' ? '' : 'disabled' }}>
            <span class="input-group-text">%</span>
        </div>
    </div>

    
 
     <div class="checkbox-container">
         <div class="form-check form-switch">
             <input class="form-check-input" type="checkbox" id="includeOnPrice" name="includeOnPrice"{{ $priceList->price === 'true' ? 'checked' : '' }} {{ $priceList->enableVat === 'true' ? '' : 'disabled' }} onchange="handleExclusiveSelection(this)">
             <label class="form-check-label" for="includeOnPrice">Include on Price</label>
         </div>
         
         <div class="form-check form-switch">
             <input class="form-check-input" type="checkbox" id="external" name="external" {{ $priceList->external === 'true' ? 'checked' : '' }} {{ $priceList->enableVat === 'true' ? '' : 'disabled' }} onchange="handleExclusiveSelection(this)">
             <label class="form-check-label" for="external">External</label>
         </div>
     </div>
     </div>

<!-- 
<div id="vatFields" class="{{ $priceList->enableVat === 'true' ? '' : 'VAThidden' }}">
    <label for="vatPercentage">VAT Percentage:</label>
    <input type="number" id="vatPercentage" name="vatPercentage" min="0" max="100" value="{{ $priceList->vatPercentage }}" {{ $priceList->enableVat === 'true' ? '' : 'disabled' }}> %

    <br><br>
</div>


<div class="checkbox-container">
    <label for="includeOnPrice">Include on Price:</label>
    <input type="checkbox" id="includeOnPrice" name="includeOnPrice" {{ $priceList->price === 'true' ? 'checked' : '' }} {{ $priceList->enableVat === 'true' ? '' : 'disabled' }} onchange="handleExclusiveSelection(this)">
    
    <label for="external">Or External:</label>
    <input type="checkbox" id="external" name="external" {{ $priceList->external === 'true' ? 'checked' : '' }} {{ $priceList->enableVat === 'true' ? '' : 'disabled' }} onchange="handleExclusiveSelection(this)">
</div> -->

<script>
function toggleVATFields() {
    var vatCheckbox = document.getElementById('vatCheckbox');
    var vatFields = document.getElementById('vatFields');
    var vatPercentage = document.getElementById('vatPercentage');
    var includeOnPrice = document.getElementById('includeOnPrice');
    var external = document.getElementById('external');

    if (vatCheckbox.checked) {
        vatFields.classList.remove('VAThidden');
        vatPercentage.disabled = false;
        includeOnPrice.disabled = false;
        external.disabled = false;
    } else {
        vatFields.classList.add('VAThidden');
        vatPercentage.disabled = true;
        includeOnPrice.disabled = true;
        external.disabled = true;
    }
}

function handleExclusiveSelection(checkbox) {
    if (checkbox.checked) {
        if (checkbox.id === 'includeOnPrice') {
            document.getElementById('external').checked = false;
        } else if (checkbox.id === 'external') {
            document.getElementById('includeOnPrice').checked = false;
        }
    }
}
</script>

<!-- multiple payments -->

<style>
    .multiplepaymenthidden {
        display: none;
    }
</style>


<div class="mb-3">
    <div class="input-group">
        <label class="input-group-text" for="priceType">Select Price Type:</label>
        <select class="form-select" id="priceType" name="priceType" onchange="togglePriceOptions()">
        <option value="recurring" {{ $priceList->selectPriceType === 'recurring' ? 'selected' : '' }}>Recurring</option>
         <option value="oneTime" {{ $priceList->selectPriceType === 'oneTime' ? 'selected' : '' }}>One Time</option>
        </select>
    </div>
</div>

<!-- <label for="priceType">Select Price Type:</label>
<select id="priceType" name="priceType" onchange="togglePriceOptions()">
    <option value="recurring" {{ $priceList->selectPriceType === 'recurring' ? 'selected' : '' }}>Recurring</option>
    <option value="oneTime" {{ $priceList->selectPriceType === 'oneTime' ? 'selected' : '' }}>One Time</option>
</select> -->

<div id="oneTimeOptions" class="{{ $priceList->selectPriceType === 'oneTime' ? '' : 'hidden' }}">
    <label>Payment Options:</label><br>
    <input type="checkbox" id="singlePayment" name="paymentType" value="singlePayment" {{ $priceList->singlePayment ? 'checked' : '' }} onchange="togglePaymentOption(this); ensureSinglePaymentOption(this)">

    <label for="singlePayment">Single Payment</label><br>
    
    <input type="checkbox" id="multiplePayments" name="paymentType" value="multiplePayments" {{ $priceList->multiplePayments ? 'checked' : '' }} onchange="togglePaymentOption(this); ensureSinglePaymentOption(this)">

    <!-- <label for="multiplePayments">Multiple Payments</label><br>
    <div id="multiplePaymentOptions" class="{{ $priceList->multiplePayments ? '' : 'multiplepaymenthidden' }}">
        <label for="minPaymentRange">Min Range:</label>
        <input type="range" id="minPaymentRange" name="minPaymentRange" min="0" max="10000" value="{{ $priceList->paymentMinRange }}" oninput="updateMinValuepayment(this.value)">
        <span id="minPaymentValue">{{ $priceList->paymentMinRange }}</span><br>
        <label for="maxPaymentRange">Max Range:</label>
        <input type="range" id="maxPaymentRange" name="maxPaymentRange" min="0" max="1000000" value="{{ $priceList->paymentMaxRange }}" oninput="updateMaxValuepayment(this.value)">
        <span id="maxPaymentValue">{{ $priceList->paymentMaxRange }}</span><br>
 
        <div class="row mt-3">
        <div class="col-sm">
            <div class="input-group">
                <label class="input-group-text" for="selection">Example Text:</label>
                <input type="text" class="form-control" id="minPayment" name="minPayment" value="{{ $priceList->paymentExampleText }}">
            </div>
        </div>
        </div>
        
    </div> -->

    <label for="multiplePayments">Multiple Payments</label><br>
    <div id="multiplePaymentOptions" class="{{ $priceList->multiplePayments ? '' : 'multiplepaymenthidden' }}">
        <label for="minPaymentRange">Min Range:</label>
        <div id="minPaymentRangeSlider"></div>
        <span id="minPaymentValue">{{ $priceList->paymentMinRange }}</span><br>
        
        <label for="maxPaymentRange">Max Range:</label>
        <div id="maxPaymentRangeSlider"></div>
        <span id="maxPaymentValue">{{ $priceList->paymentMaxRange }}</span><br>

        <!-- Additional input fields for min and max range -->
        <div class="row mt-3">
            <div class="col-sm">
                <div class="input-group">
                    <label class="input-group-text" for="selection">Example Text:</label>
                    <input type="text" class="form-control" id="minPayment" name="minPayment" value="{{ $priceList->paymentExampleText }}">
                </div>
            </div>
        </div>
    </div>


</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.7.0/nouislider.min.js"></script>
    <script>

    // Initialize min payment range slider
    var minPaymentRangeSlider = document.getElementById('minPaymentRangeSlider');
    noUiSlider.create(minPaymentRangeSlider, {
        start: [ ' {{ $priceList->paymentMinRange }} ' ],
        connect: 'lower',
        range: {
            'min': 0,
            'max': 10000
        }
    });

    // Update min payment value span when slider value changes
    minPaymentRangeSlider.noUiSlider.on('update', function (values, handle) {
        document.getElementById('minPaymentValue').innerHTML = values[handle];
    });

    // Initialize max payment range slider
    var maxPaymentRangeSlider = document.getElementById('maxPaymentRangeSlider');
    noUiSlider.create(maxPaymentRangeSlider, {
        start: [ '{{ $priceList->paymentMaxRange }}'],
        connect: 'lower',
        range: {
            'min': 0,
            'max': 1000000
        }
    });

    // Update max payment value span when slider value changes
    maxPaymentRangeSlider.noUiSlider.on('update', function (values, handle) {
        document.getElementById('maxPaymentValue').innerHTML = values[handle];
    });


    </script>

<script>
        // Initial setup to reflect the data from the database
        document.addEventListener('DOMContentLoaded', function() {
            var singlePaymentCheckbox = document.getElementById('singlePayment');
            var multiplePaymentsCheckbox = document.getElementById('multiplePayments');
            
            // Reflect data for Single Payment checkbox
            if ("{{ $priceList->singlePayment }}" === "true") {
                singlePaymentCheckbox.checked = true;

                var multiplePaymentOptions = document.getElementById('multiplePaymentOptions');
                multiplePaymentOptions.classList.add('multiplepaymenthidden');
            
            } else {
                singlePaymentCheckbox.checked = false;
            }

            // Reflecttion of data for Multiple Payments checkbox
            if ("{{ $priceList->multiplePayments }}" === "true") {
                multiplePaymentsCheckbox.checked = true;
            } else {
                multiplePaymentsCheckbox.checked = false;
                
            }
        });

       function togglePriceOptions() {
        var priceType = document.getElementById('priceType').value;
        var oneTimeOptions = document.getElementById('oneTimeOptions');

        if (priceType === 'oneTime') {
            oneTimeOptions.classList.remove('hidden');
        } else {
            oneTimeOptions.classList.add('hidden');
        }
    }
    // Function to toggle the visibility of payment options
    function togglePaymentOption(checkbox) {
        var singlePaymentCheckbox = document.getElementById('singlePayment');
        var multiplePaymentsCheckbox = document.getElementById('multiplePayments');
        var multiplePaymentOptions = document.getElementById('multiplePaymentOptions');

        if (checkbox.checked) {
            if (checkbox.id === 'singlePayment') {
                singlePaymentCheckbox.checked = true;
                multiplePaymentsCheckbox.checked = false; // Uncheck Multiple Payments
                multiplePaymentOptions.classList.add('multiplepaymenthidden');
            } else if (checkbox.id === 'multiplePayments') {
                multiplePaymentsCheckbox.checked = true;
                singlePaymentCheckbox.checked = false; // Uncheck Single Payment
                multiplePaymentOptions.classList.remove('multiplepaymenthidden');
            }
        } else {
            multiplePaymentOptions.classList.add('multiplepaymenthidden');
        }
    }

    // Function to ensure only one payment option is checked at a time
    function ensureSinglePaymentOption(checkbox) {
        var singlePaymentCheckbox = document.getElementById('singlePayment');
        var multiplePaymentsCheckbox = document.getElementById('multiplePayments');

        if (checkbox.checked && checkbox.id === 'singlePayment') {
            singlePaymentCheckbox.checked = true;
            multiplePaymentsCheckbox.checked = false;
        } else if (checkbox.checked && checkbox.id === 'multiplePayments') {
            singlePaymentCheckbox.checked = false;
            multiplePaymentsCheckbox.checked = true;
        }
    }

    // Function to update the min range value
    function updateMinValuepayment(value) {
        document.getElementById('minPaymentValue').innerText = value;
    }

    // Function to update the max range value
    function updateMaxValuepayment(value) {
        document.getElementById('maxPaymentValue').innerText = value;
    }
    </script>

<!--    ------------------------------------------------   -->

<div class="row">

</div>

<!-- Main update button to insert data in database -->
<button type="button"  id="saveButton" class="btn btn-success me-2 btn-lg"  >Update</button>




            </div>

            <div class="col-3 bg-secondary"> <!-- 25% width -->
                 
              <p>  example text  will come in future  </p>

            </div>

        </div>
    </div>
 




 
 



<script>
    // Function to save the edited data
    document.getElementById('saveButton').addEventListener('click', function() {
    // Gather data from form all fields 
    var priceName = document.getElementById('priceName').value;
    var currency = document.getElementById('currency').value;

    var enableVat = document.getElementById('vatCheckbox').checked;
    var vatPercentage = document.getElementById('vatPercentage').value;
    var includeOnPrice = document.getElementById('includeOnPrice').checked;

    console.log('includeOnPrice :' , includeOnPrice);
    
    var external = document.getElementById('external').checked;

  

    
    // Validation flag
    var isValid = true;
    // to Get the values for the fixedInput and dynamicInput based on selection
    
    var minRange = '';
    var maxRange = '';
    var selectionValue = document.getElementById('selection').value;
    var fixedValue = document.getElementById('fixedValue').value;
    if (selectionValue === 'fixed') {
        fixedValue = document.getElementById('fixedValue').value;
 
     }
    if (selectionValue === 'dynamic') {
        fixedValue = document.getElementById('fixedValue2').value;
        var minRangeSlider = document.getElementById('minRangeSlider');
        minRange = minRangeSlider.noUiSlider.get();
        var maxRangeSlider = document.getElementById('maxRangeSlider');
        maxRange = maxRangeSlider.noUiSlider.get();
      // Convert values to numbers before comparison
        var fixedValueNum = parseFloat(fixedValue);
        var minRangeNum = parseFloat(minRange);
        var maxRangeNum = parseFloat(maxRange);

        // Check if fixedValue falls outside the range
        if (fixedValueNum < minRangeNum || fixedValueNum > maxRangeNum) {
            console.log('fixedValue:', fixedValueNum);
            console.log('minRange:', minRangeNum);
            console.log('maxRange:', maxRangeNum);

            isValid = false;
            console.log('1st range isValid:', isValid);
            alert('Fixed value should be greater than minRange and lower than maxRange.');
        }


    }
 
   

    var priceType = document.getElementById('priceType').value;
    if (priceType === 'oneTime'){
        var multiplePayments = document.getElementById('multiplePayments').checked;
        if (multiplePayments === true){
           // var minPaymentRange = document.getElementById('minPaymentRange').value;
            //var maxPaymentRange = document.getElementById('maxPaymentRange').value;
            var paymentExampleText = document.getElementById('minPayment').value; 
        
                var minPaymentRangeSlider = document.getElementById('minPaymentRangeSlider');
                var maxPaymentRangeSlider = document.getElementById('maxPaymentRangeSlider');

                // Get the values from the slider objects
                var minPaymentRange = minPaymentRangeSlider.noUiSlider.get();
                var maxPaymentRange = maxPaymentRangeSlider.noUiSlider.get();

                    // Convert values to numbers before comparison
                var minPaymentRangeNum = parseFloat(minPaymentRange);
                var maxPaymentRangeNum = parseFloat(maxPaymentRange);
                console.log('minPaymentRange nummmm:', minPaymentRangeNum);
                    console.log('maxPaymentRange nummmm:', maxPaymentRangeNum);
                    console.log('2nd range check isValid:', isValid);

                // Validate if payment range is valid
                if (minPaymentRangeNum>maxPaymentRangeNum) {
                    isValid = false;
                    console.log('minPaymentRange:', minPaymentRangeNum);
                    console.log('maxPaymentRange:', maxPaymentRangeNum);
                    console.log('2nd range check isValid:', isValid);
                    alert('minPaymentRange should be lower than maxPaymentRange.');
                }

        }

        var singlePayment = document.getElementById('singlePayment').checked;
        if (singlePayment === true){
          // do nothing 
          var minPaymentRange = '';
          var maxPaymentRange = '';
          var paymentExampleText = '';
        }
    }
  
    console.log('isValid :' , isValid );  
   
    if(isValid) {
    var data = {
        pricename: priceName,
        currency: currency,
        fixedvalue: fixedValue,
        dynamicminRange: minRange,
        dynamicmaxRange: maxRange,
        enableVat: enableVat,
        vatPercentage: vatPercentage,
        includeOnPrice: includeOnPrice,
        external: external,
        priceType: priceType,
        singlePayment: singlePayment,
        multiplePayments: multiplePayments,
        paymentMinRange: minPaymentRange,
        paymentMaxRange: maxPaymentRange,
        paymentExampleText: paymentExampleText
    };

    // Send AJAX request to update the price
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/update-price/' + {{ $priceList->id }},
        type: 'POST',
        data: data,
        headers: {
                'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            console.log(response);
            alert('Price updated successfully!');
            // Redirect to a new page or perform any other action upon success
            window.location.href = '/Price-List';
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Fill all the Form while updating price.');
        }
    });
 }
});

</script>

@endsection