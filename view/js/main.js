$(document).ready(function() {

// Add book form previous and next buttons
    $('#section1Next').on('click', function() {
        $("#section-2").css("display", "block");
        $("#section-1").css("display", "none");
    });

    $('#section2Prev').on('click', function() {
        $("#section-2").css("display", "none");
        $("#section-1").css("display", "block");
    });

    $('#section2Next').on('click', function() {
        $("#section-2").css("display", "none");
        $("#section-3").css("display", "block");
    });

    $('#section3Prev').on('click', function() {
        $("#section-3").css("display", "none");
        $("#section-2").css("display", "block");
    });


 // Add book form, select an existing or new author show/hide functionality
     $('input[name=authorSelect]').change(function(){

        if ($(this).val()=="existingAuthor") {
           $('#existingAuthor').slideDown();
            $('#newAuthor').hide();
        } else {
           $('#newAuthor').slideDown();
           $('#existingAuthor').hide();
        }
     });

// Upload cover image
    var $uploadCrop,
    tempFilename,
    rawImg,
    imageId;
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    $uploadCrop = $('#upload-demo').croppie({
        viewport: {
            width: 203,
            height: 297,
        },
        enforceBoundary: false,
        enableExif: true
    });

    $('#cropImagePop').on('shown.bs.modal', function(){
        // alert('Shown pop');
        $uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function(){
            console.log('jQuery bind complete');
        });
    });

    $('.item-img').on('change', function () {
        imageId = $(this).data('id');
        tempFilename = $(this).val();
        $('#cancelCropBtn').data('id', imageId);
        readFile(this);
    });

    $('.clearImageBtn').on('click', function (){
        $('#coverImageSelect').val('');
    });

    $('#cropImageBtn').on('click', function (ev) {
        $('#coverImageSelect').hide();
        $('.deleteImage').show();
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpeg',
            size: {width: 203, height: 297}
        }).then(function (resp) {
            $('#item-img-output').attr('src', resp);
            $( ".coverImageOutput").val(resp);
            $('#cropImagePop').modal('hide');
        });
    });

    $('.deleteImage').on('click', function (){
        $('#item-img-output').attr('src', '');
        $( ".coverImageOutput").val('');
        $( ".deleteCoverImage").val('true');
        $('#coverImageSelect').val('');
        $('#coverImageSelect').css("display","block");
        $('.deleteImage').hide();
    });

 // Mobile menu functionality
     $(function() {
        $( ".mobileMenu" ).click(function() {
            $( "nav" ).toggle();
        });
    });

});
